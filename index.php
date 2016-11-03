<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="convert.php" enctype="multipart/form-data" method="POST">
		Select file to upload:
	    file <input type="file" name="fileToUpload" id="fileToUpload"><br>
	    screen width <input type="number" name="width"><br>
	    screen height <input type="number" name="height"><br>
	    dpi <input type="number" name="dpi"><br>
	    compress file <input type="checkbox" name="compress">
	    <input type="submit" value="Upload File" name="submit">
	</form>
	
</body>
</html>