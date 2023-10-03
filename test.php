<?php include('handleForm.php'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title> Test handleFile class with an simple HTML form </title>
</head>
<body style="text-align: center;">

<div style="display: inline-block; padding: 50px; margin: 50px auto; text-align: center; background-color: lightblue; border-radius: 5px;">
<form method="post" enctype="multipart/form-data" name="uploadFile">
<input type="file" name="file">
<button type="submit"> Upload File </button>
</form>
</div>

</body>
</html>
