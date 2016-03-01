<?php
    #need to add this to php.ini:
    #file_uploads = On
    $directory = "/uploads";
    $target_dir = sys_get_temp_dir();//"uploads/;
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
		//if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $directory)){
			//echo "The file " . basename($_FILES["fileToUpload"]["name"]). " has been uploaded.";
      if (($handle = fopen($target_file, "r")) !== FALSE) {
        while (($stocksInfo = fgetcsv($handle, 1000, ",")) !== FALSE) {
          $size = count($stocksInfo);
          echo '------------------------------'. "\n";
          $row++;

          //Stock information from API
          $symbol = $stocksInfo[0];
          $stockName = $stocksInfo[1];
          $currentPrice = $stocksInfo[2];
          $previousClose = $stocksInfo[3];
		}
		else{
			echo "Error uploading file";
		}
	}
?>
