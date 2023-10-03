<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title> Test handleFile class with an simple HTML form </title>
</head>
<body style="text-align: center;">

<style type="text/css">
clear {display: block; clear: both;}
wrapper {display: block; max-width: 500px; padding: 20px; margin: 10px auto; text-align: center; background-color: lightblue; border-radius: 5px;}
result {display: block; max-width: 500px; padding: 20px; margin: 10px auto; text-align: center; background-color: cadetblue; border-radius: 5px; text-align: left;}
result b {color: red;}
</style>

<?php

ini_set('display_errors', 1);
include('handleFile.php');

if ($_POST['action'] == 'process') {
	
	$handle = new handleFile();
	
	echo '<result>';
	
	$file = $_FILES['file']['tmp_name'];
	if ($handle->getFile($file) == false) echo '<b> ERROR: </b> file post failed ! <br>';
	else {
	
		echo 'File size: ' . $handle->size('m', 2) . ' Megabytes <br>';
		
		$mime = $handle->mime();
		if ($mime == false) echo '<b> ERROR: </b> file format not expected ! <br>';
		else echo 'File Type: ' . $mime . '<br>';
		
		$animate = $handle->isAnimate();
		if ($animate == false) echo 'File is not animation ! <br>';
		else echo 'File is animation ! <br>';
		
		$upload = $handle->upload('upload/');
		if ($upload == false) echo '<b> ERROR: </b> file upload failed ! <br>';
		else echo 'File upload successfullty in path : ' . $upload . '<br>';
		
		$resize = $handle->resize(500, '_resized');
		if ($resize == false) echo '<b> ERROR: </b> file resize failed ! <br>';
		else echo 'File resize successfullty in path : ' . $resize . '<br>';
		
		$watermark = $handle->watermark('logo.png');
		if ($watermark == false) echo '<b> ERROR: </b> file watermark failed ! <br>';
		else echo 'File watermark successfullty in path : ' . $watermark . '<br>';
		
		$crop = $handle->crop(400, 300, '_croped');
		if ($crop == false) echo '<b> ERROR: </b> file crop failed ! <br>';
		else echo 'File crop successfullty in path : ' . $crop . '<br>';
		
	}
	
	echo '</result>';
	echo '<clear></clear>';
}

?>

<wrapper>
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="action" value="process">
<input type="file" name="file">
<button type="submit"> Upload File </button>
</form>
</wrapper>

</body>
</html>
