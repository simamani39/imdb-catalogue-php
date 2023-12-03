<?php
ini_set('display_errors', 1);
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

// Output the generated PDF to Browser
ob_end_clean();
//$dompdf->stream();
$dompdf->stream("Movietown ".date("d-m-y").".pdf");
?>