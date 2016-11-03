<?php  
	$timeInital = time();

	$target_dir = "/uploads/";
	$_FILES["fileToUpload"]["name"] = str_replace(' ', '_', $_FILES["fileToUpload"]["name"]);
	$target_file = $target_dir .(string)time() .basename($_FILES["fileToUpload"]["name"]);

	$uploadOk = 1;
	
	// Check if file already exists
	if (file_exists($target_file)) {
	    echo "Sorry, file already exists.";
	    $uploadOk = 0;
	}
	
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
	    } else {
	    	print_r($_FILES);
	        echo "Sorry, there was an error uploading your file.";
	        die();
	    }
	}

	$timeUpload = time();
	$gap2 = $timeUpload - $timeInital;
	echo "It took ".$gap2." seconds to upload file<br>";
	// echo "<br>".$target_file."<br>";

	chmod($target_file, 0777);

	class Process{
	    private $pid;
	    private $command;

	    public function __construct($cl=false){
	        if ($cl != false){
	            $this->command = $cl;
	            $this->runCom();
	        }
	    }
	    private function runCom(){
	        $command = 'nohup '.$this->command.' > /dev/null 2>&1 & echo $!';
	        exec($command ,$op);
	        print_r($op);
	        $this->pid = (int)$op[0];
	    }

	    public function setPid($pid){
	        $this->pid = $pid;
	    }

	    public function getPid(){
	        return $this->pid;
	    }

	    public function status(){
	        $command = 'ps -p '.$this->pid;
	        exec($command,$op);
	        if (!isset($op[1]))return false;
	        else return true;
	    }

	    public function start(){
	        if ($this->command != '') $this->runCom();
	        else return true;
	    }

	    public function stop(){
	        $command = 'kill '.$this->pid;
	        exec($command);
	        if ($this->status() == false)return true;
	        else return false;
	    }
	}
	print_r($_POST);
	$width = "480";
	$height = "800";
	$dpi = "250";

	if(isset($_POST["width"]) && $_POST["width"] != ""){
		$width = $_POST["width"];
	}

	if(isset($_POST["height"]) && $_POST["height"] != ""){
		$height = $_POST["height"];
	}

	if(isset($_POST["dpi"]) && $_POST["dpi"] != ""){
		$dpi = $_POST["dpi"];
	}


	$cmd = "k2pdfopt ".$target_file." -ui- -j 1 -w ".$width." -h ".$height." -odpi ".$dpi." -col 1";
	print_r($cmd);
	$process = new Process($cmd);
	while($process->status()){
		sleep(1);
	}

	$timeMiddle = time();
	$gap1 = $timeMiddle - $timeUpload;
	echo "It took ".$gap1." seconds to change file<br>";

	$newFile = explode(".pdf", $target_file)[0]."_k2opt.pdf";
	// echo "<br>".$newFile."<br>";

	echo "Download your original converted file <a href='test.php?file=".$newFile."'>Download</a><br>";
	if(!isset($_POST["compress"])){
		die();
	}

	$outFile = explode(".pdf", $newFile)[0]."_compressed.pdf";
	$compressCommand = "gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/ebook -dNOPAUSE -dQUIET -dBATCH -sOutputFile=".$outFile." ".$newFile;

	$process1 = new Process($compressCommand);
	while($process1->status()){
		sleep(1);
	}
	// echo "<br>".$outFile."<br>";
	echo "Download your compressed file <a href='test.php?file=".$outFile."'>Download</a><br>";
	$timeFinal = time();
	$gap = $timeFinal - $timeMiddle;
	echo "It took ".$gap." seconds to compress<br>";

?>