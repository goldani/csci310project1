<?php

  include 'vendor/autoload.php';
  use Parse\ParseClient;
  use Parse\ParseQuery;
  use Parse\ParseException;
  use Parse\ParseUser;
  date_default_timezone_set('America/New_York');
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
    ParseClient::initialize('W78hSNsME23VkGSZOD0JXn2XoM5Nf6GO41BgMqxE', 'H3EgW9gCr6wyP8MfL3Eobz1mWJMwydyp6N2prcVF', 'mRppu4ciMuqhNsTXHoeh329Za4ShOOc1F1NN0skD');
  }

  #get current user from Parse for further query
  $currentUser = ParseUser::getCurrentUser();
  if (!$currentUser) {
    echo "error getting current user or not logged in!";
    exit();
  }

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

    //check if the ticker is real
    //check if the date is current
    //check if the price is the current

    $stocks = $currentUser->get("stocks");
    if (($file = fopen($target_file, "r")) !== FALSE) {
      while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
        if(isset($stocks)){
          if(!array_key_exists($filedata[0], $stocks)) {
            $stocks[$filedata[0]] = $filedata[3];
            echo "edef:".$filedata[3];
            //if its not there, create new
          } else{
            $stocks[$filedata[0]] += $filedata[3];
            echo "edef:".$filedata[3];
            //if its there, increment quantity by the quantity provided
            //maybe check the balance with the new amount
          }
        }
      }

      $currentUser->setAssociativeArray("stocks", $stocks);
      $currentUser->save();
      $newstocks = $currentUser->get("stocks");
      //Call API and get all the value to be put again in the lists
      $results = "";
      $format = "snap2";
      foreach ($newstocks as $key => $stock){

        $quote = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=" . $key . "&f=" . $format . "&e=.csv");
        $data = explode( ',', $quote);

        $ticker = NULL;
        $name = NULL;
        $price = NULL;
        $percent = NULL;

        if (count($data) == 5) {
          $ticker = substr($data[0], 1, -1);
          $name = substr($data[1] . $data[2], 1, -1);
          $price = "$".$data[3];
          $percent = substr($data[4], 1, -2);
        } else {
          $ticker = substr($data[0], 1, -1);
          $name = substr($data[1], 1, -1);
          $price = "$".$data[2];
          $percent = substr($data[3], 1, -2);
        }
        str_replace('"', "", $percent);
        $results .= $ticker . "_" . $name . "_" . $stock . "_" . $price . "_" . $percent . "\n";
      }

      echo $results;
    }	else{
		echo "Error uploading file";
	  }
	}
?>
