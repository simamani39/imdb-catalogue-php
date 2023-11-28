
<?php
// this is an alternative way to produce the jpeg
//uses google's api to take screenshot of the page
$yourdomain='https://yourdomain.com';
$new_url = $yourdomain.'/yourpage.html';
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

base64_to_jpeg($screenshot,"cat.jpg");
     
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<img src="<?php echo $screenshot; ?>" />
<a href="<?php echo $screenshot; ?> download">click</a>
</body>
</html>