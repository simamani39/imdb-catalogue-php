<?php  
ini_set('display_errors', 1);
//the work around for producing the jpg is by first rendering the html
//to pdf then converting the pdf to jpg
//imagic php extention is required
require 'vendor/autoload.php';
    // reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;
$options = new Options;
$options->setChroot(__DIR__);
$options->set('isRemoteEnabled', true);
//$dompdf->set_option('isHtml5ParserEnabled', true);
// instantiate and use the dompdf class
$dompdf = new Dompdf($options);

$dompdf->loadHtmlFile('yourpage.html');
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();
ob_end_clean();
// Output the generated PDF to local dir
$output = $dompdf->output();
file_put_contents('mv.pdf', $output); //
    $im = new Imagick();
$im->setResolution(300, 300);     //set the resolution of the resulting jpg
$im->readImage(__DIR__ .'/mv.pdf[0]');    //[0] for the first page
$im->setImageFormat('jpg');
//$im->writeImage('thumb.jpg'); // to save in in the local dir but since we dont need the jpg saved locally
header('Content-Type: image/jpeg');
echo $im; //the jpg file
?>
