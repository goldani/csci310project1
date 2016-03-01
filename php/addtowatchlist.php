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
  $format = snap2;

  for ($i=0; $i < $stocks; $i++) {
    # code...
  }
  #get quotes from Yahoo API
  $quote = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=" . $ticker . "&f=" . $format . "&e=.csv");
  $data = explode( ',', $quote);

  echo
} else {
  echo "";
}

?>
