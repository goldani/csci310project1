<?php

    //get file from temporary direcory where it is stored
    $target_dir = sys_get_temp_dir();
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOK = 1;
    $fileType = pathinfo($target_file,PATHINFO_EXTENSION);
	if($fileType != "csv"){
		echo "Not a CSV file";
    //do pop up instead of echo
		$uploadOK = 0;
	}
	if($uploadOK == 0){
    //do pop up instead of echo
		echo "File not imported";
	}
	else{
		//if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
			//echo "The file " . basename($_FILES["fileToUpload"]["name"]). " has been uploaded.";

      if (($file = fopen($target_file, "r")) !== FALSE) {
        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            $ticker = $data[0];
            $name = $data[1];
            $price = "$".$data[2];
            $percent = $data[3];
            $results .= $ticker . "_" . $name . "_" . $price . "_" . $percent . "\n";
        }
      echo $results;
    }	else{
			echo "Error uploading file";
		}
	}
?>
