<?php
// this php file crawls and saves resut to a local html file
ini_set('display_errors', 1);
require 'vendor/autoload.php'; //dependecies
ob_start(); //start buffering
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mtview.css">
    <title>Document</title>
</head>

<body>

    <?php

    use Goutte\Client;
    //separate input urls on new line
    if (isset($_POST["submit"])) {
        if (!empty($_POST['rawurl'])) {
            $str_arr = preg_split("/\r\n|\n|\r/", htmlspecialchars($_POST['rawurl']));
        }
    }

    echo '<page size="A4">'; //set page size
    //banner
    echo '<span class="banner"><img class="hlogo" src="mtlogo.jpg">
    <h2 class="btext">Box Office + Movies' . date("d/m/y") . '</h2>
    </span><br>'; // end of banner
    echo '<div class="filler"></div><br>'; // filler elelemnt because of dom pdf

    //loop based on number of url passed
    foreach ($str_arr as $url) {
        if ($url != null) {
            $client = new Client(); //instantiate crawler object
            $crawler = $client->request('GET', $url);
            //elements 
            $title = $crawler->filter('.hero__primary-text')->text(); //title
            $ratings = $crawler->filter("[data-testid*=hero-rating-bar__aggregate-rating__score] > span")->text(); //rating
            $dur = array(); //contains year,age,duration
            $crawler->filter('.ipc-inline-list--show-dividers')->eq(1)->filter('li')->each(function ($node) {
                global $dur;
                array_push($dur, $node->text());
            });
            $poster = $crawler->filter('.ipc-image')->attr('src'); //poster
            $disc = $crawler->filter("[data-testid*=plot-l]")->text(); //plot
            $genre = ""; //genre
            //add each genere
            $crawler->filter('.ipc-chip-list__scroller')->filter('span')->each(function ($node) {
                global $genre;
                $genre = $genre . $node->text() . " "; // each genere;

            });
            //end of elements
            echo '<div class="main">'; //main box
            echo '<span class="imgg"><img class="poster" src="' . $poster . '"></span>'; // poster
            $titlelength = strlen($title); //title length
            $hsize = $titlelength <= 25 ? 4 : 5; // h4 if title length less than 25, h5 elsewise
            print '<span class="title"><h' . $hsize . ' style="width: 218px;overflow: hidden;height: 20px;text-overflow: ellipsis;white-space: nowrap;">'
                . $title . '</h' . $hsize . '></span>'; // title
            print '<span class="genere"><h6>' . $genre . '</h6></span>'; //  genere
            print '<span class="dur"><h6>' . $dur[count($dur) - 1] . '</h6></span>'; //run time or duration
            print '<br>';
            print '<span class="disc"><p>' . $disc . '</p></span>'; // discription
            print '<br>';
            print '<span class="age" style="border-color: #ffcc01;"><h2 style="margin-bottom: -3px">' ;
            print $dur[count($dur) - 2] == "Not Rated" ? "NR" : $dur[count($dur) - 2] . '</h2></span>'; //age
            $rating = floatval($ratings); //to compare rating value
            //underline color condition that reflects rating
            $colorz = "red";
            if ($rating <= 4.5) {
                $colorz = "red";
            } elseif ($rating <= 6.5) {
                $colorz = "dodgerblue";
            } elseif ($rating <= 8.5) {
                $colorz = "lawngreen";
            } else {
                $colorz = "forestgreen";
            }
            print '<span class="rating" style="border-color: ' . $colorz . '; z-index:1;"><h2 style="margin-bottom: -3px">' . $ratings . '</h2></span>'; // rating
            print '<img class="bg" src="mtbg.jpg">'; // bg- additional php extention requirment for png in dom pdf
            echo '</div>';
        }
    }
    //footer
    echo '<span class="footer"><img src="phone.svg" style="width: 20px;margin-top: 10px;margin-left: 236px;"><span style="
display: inline-block;margin-top: 12px;margin-left: 10px;position: absolute;"> 0900000000</span>
<img src="mtloc.svg" style="width: 20px;/* margin-top: 10px; */margin-left: 139px;"><span style="
margin-left: 10px;margin-top: 12px;display: inline-block;position: absolute;">Your Adress Here</span></span>'; // end of footer
    echo '<div></div>'; //sacrificial lamb here because dom pdf keeps pushing the last element to the next page
    echo '</page>';
    echo '</body>
</html>';
    file_put_contents('yourpage.html', ob_get_contents()); //saves the html file
    ?>