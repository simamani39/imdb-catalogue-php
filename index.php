<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <script language="javascript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.js"></script>
<script language="javascript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/perl/perl.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.css"></link>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/theme/abbott.min.css"></link>
    <title>Movie Town CAT</title>
</head>
<body>
<form target="frame" action="movietown.php" method="post">
    
    <textarea name="rawurl" id="code" placeholder="paste links separated with a comma" rows="8" cols="60"></textarea>
    <input type="submit" name="submit" value="Get Data">
</form>
<form action="renderpdf.php" method="post">
    
    
    <input type="submit" name="submit" value="Save PDF!" style="margin-top: -47px; margin-left: 148px;">
</form>
<a href="Movie_Town.php" target="_blank" download>
<button type="submit" name="submit" value="Save Jpg!" style="margin-top: -47px; margin-left: 300px;position: absolute;">Save JPG!</button></a>
<iframe src="yourpage.html" name="frame" height="300px" width="800px" title="Iframe"></iframe>
</body>
<script>
    function val()
    {
      if(document.getElementById('code').value==null || document.getElementById('code').value=="")
alert("blank text area")
    } 
var editor = CodeMirror.fromTextArea(document.getElementById('code'), {
    lineNumbers: true,
    mode: 'text/x-perl',
    theme: 'abbott',
});
</script>
</html>