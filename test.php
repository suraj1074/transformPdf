<?php 
	$outFile = $_GET["file"];
	if(file_exists($outFile)){
		echo "Hello";
		if ($fd = fopen ($outFile, "r")) {
			$fsize = filesize($outFile);
		    $path_parts = pathinfo($outFile);
		    $ext = strtolower($path_parts["extension"]);
		    switch ($ext) {
		        case "pdf":
			        header("Content-Type: application/pdf");
			        header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a file download
		        break;
			        // add more headers for other content types here
			        default;
			        header("Content-type: application/octet-stream");
			        header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
		        break;
		    }
		    header("Content-length: $fsize");
		    header("Cache-control: private"); //use this to open files directly
		    while(!feof($fd)) {
		        $buffer = fread($fd, 2048);
		        echo $buffer;
		    }
		}
	}
	else{
		echo "Some error occured";
	}

 ?>