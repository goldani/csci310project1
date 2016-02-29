<?php
    #need to add this to php.ini:
    #file_uploads = On
    $target_dir = "uploads/"
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOK = 1;
    $fileType = pathinfo($target_file,PATHINFO_EXTENSION);
	if($fileType != "csv"){
		echo "Not a CSV file";
		$uploadOK = 0;
	}
	if($uploadOK == 0){
		echo "File not imported";
	}
	else{
		if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
			echo "The file " . basename($_FILES["fileToUpload"]["name"]). " has been uploaded.";
		}
		else{
			echo "Error uploading file";
		}
	}
?>
