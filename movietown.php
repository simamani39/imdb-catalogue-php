<?php
require 'vendor/autoload.php';
if(file_exists('Movietown.jpg'))
    {
        unlink('Movietown.jpg');
        
    }
// Start the buffering //
ob_start();
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
    
    if(isset($_POST["submit"])){
      if(!empty($_POST['rawurl'])){
      $str_arr = preg_split("/\r\n|\n|\r/", htmlspecialchars($_POST['rawurl']));
      }
    }

    

    echo '<page size="A4">';
    echo '<span class="banner"><img class="hlogo" src="mtlogo.jpg">
    <h2 class="btext">Box Office + Movies' .date("d/m/y"). '</h2>
    </span><br>'; // banner
    echo '<div class="filler"></div><br>';  // for filler
    //$color=array("red", "yellow", "steelblue","chartreuse","indigo","olive","tomato","aquamarine","goldenrod","limegreen");
    
    
    foreach ($str_arr as $url){
      if($url !=null){

      
      $client = new Client();
      $crawler = $client->request('GET', $url);
    
    echo '<div class="main">';

    echo '<span class="imgg"><img class="poster" src="'.$crawler->filter('.ipc-image')->attr('src').'"></span>'; // poster
    $titlelength=strlen($crawler->filter('.sc-7f1a92f5-1')->text());
    $hsize=$titlelength<=25? 4 : 5;
    print '<span class="title"><h'.$hsize.' style="width: 218px;overflow: hidden;
    height: 20px;
    text-overflow: ellipsis;
    white-space: nowrap;">'.$crawler->filter('.sc-7f1a92f5-1')->text().'</h'.$hsize.'></span>';  // title
    print '<span class="genere"><h6>';  //genere
    $crawler->filter('.ipc-chip-list__scroller')->filter('span')->each(function ($node) {
    print $node->text()." ";  // each genere;
        
    });
    
    print '</h6></span>';  // end of genere
    print '<span class="dur"><h6>'; //duration and edit css file
    $dur=array();
    $crawler->filter('.sc-e226b0e3-3')->filter('ul')->filter('li')->each(function ($node) {
    //print $node->text().'| ';  // duration
       global $dur;
       array_push($dur,$node->text());
   });
   print $dur[count($dur) - 1];
 print '</h6></span>';
    print '<br>';
        
    print '<span class="disc"><p>'.$crawler->filter('.sc-466bb6c-2')->text().'</p></span>';  // discription
    print '<br>';
    $rating=floatval($crawler->filter('.sc-bde20123-1')->text());
    $colorz="red";
    if($rating<=4.5){
      $colorz="red";
    }
    elseif($rating<=6.5){
      $colorz="dodgerblue";
    }
    elseif($rating<=8.5){
      $colorz="lawngreen";
    }
    else{
      $colorz="forestgreen";
    }
    print '<span class="age" style="border-color: #ffcc01;"><h2 style="margin-bottom: -3px">'; //age
   print $dur[count($dur) - 2]== "Not Rated" ? "NR" :$dur[count($dur) - 2];
 print '</h2></span>';
    print '<span class="rating" style="border-color: '.$colorz.'; z-index:1;"><h2 style="margin-bottom: -3px">'.$crawler->filter('.sc-bde20123-1')->text().'</h2></span>';  // rating
    print '<img class="bg" src="mtbg.jpg">'; // bg
      // echo '<img src="https://symfony.com/images/network/sy1certif_01.webp">';
   echo '</div>';
   
}
}
echo '<span class="footer"><img src="phone.svg" style="width: 20px;margin-top: 10px;margin-left: 236px;"><span style="
display: inline-block;margin-top: 12px;margin-left: 10px;position: absolute;"> 0909681339</span> 
<img src="mtloc.svg" style="width: 20px;/* margin-top: 10px; */margin-left: 139px;"><span style="
margin-left: 10px;margin-top: 12px;display: inline-block;position: absolute;">Piassa Dashen Bank colble Stone</span></span>'; // end of footer
echo '<div></div>';
echo '</page>';
echo '</body>
</html>';
   file_put_contents('yourpage.html', ob_get_contents());
    ?>
<?php

$new_url = 'https://mt.unityyouthproject.com/yourpage.html';
$url     = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url='.$new_url;

$url     = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url='.$new_url;

$data = file_get_contents($url);

$decoded_data = json_decode($data, true);
$audits= $decoded_data['lighthouseResult']['fullPageScreenshot'];

$decoded_screenshot = $audits['screenshot']['data'];
$screenshot = str_replace(array('_','-'),array('/','+'), $decoded_screenshot);
function base64_to_jpeg($base64_string, $output_file) {
    // open the output file for writing
    $ifp = fopen( $output_file, 'wb' ); 

    $data = explode( ',', $base64_string );

    fwrite( $ifp, base64_decode( $data[ 1 ] ) );

    // clean up the file resource
    fclose( $ifp ); 

    return $output_file; 
}

base64_to_jpeg($screenshot,"Movietown.jpg");
     
?>    

