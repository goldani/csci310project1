<?php

//-----------------------------------------------------
// The front end Javascript will call buy.php with ?ticker="TICKERNAME"
//-----------------------------------------------------

#initialize databse connection
include '../vendor/autoload.php';
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

$ticker = $_GET['ticker'];
$stocks = $currentUser->get("stocks");

if(isset($stocks) && !array_key_exists($ticker, $stocks)) {
  //add to stocks array, the new value for the watch list and the
  $stocks[$ticker] = 0;

  #in order to buy a stock, we need to know current price. compant name tag is used in comformation
  $format = "snap2";

  foreach ($stocks as $key => $stock){
    if($stock == 0){
      #get quotes from Yahoo API
      $quote = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=" . $key . "&f=" . $format . "&e=.csv");
      $data = explode( ',', $quote);

      $ticker = NULL;
      $name = NULL;
      $price = NULL;
      $percent = NULL;

      if (count($data) == 5) {
        $ticker = substr($data[0], 1, -1);
        $name = substr($data[1] . $data[2], 1, -1);
        $price = substr($data[3], 1, -1);
        $percent = substr($data[4], 1, -2);
      } else {
        $ticker = substr($data[0], 1, -1);
        $name = substr($data[1], 1, -1);
        $price = substr($data[2], 1, -1);
        $percent = substr($data[3], 1, -2);
      }
      str_replace('"', "", $percent);
      $results .= $ticker . "_" . $name . "_" . $stock . "_" . $price . "_" . $percent . "\n";
    }
  }
  $currentUser->setAssociativeArray("stocks", $stocks);
  $currentUser->save();

  echo $results;

} else {
  echo "";
}

?>
