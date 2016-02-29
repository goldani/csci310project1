<?php
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
  echo "eror getting current user or not logged in!";
  exit();
}

#load the ticker to buy and quantity
$ticker = $_GET['ticker'];
$quantity = $_GET['quantity'];

#in order to buy a stock, we need to know current price. compant name tag is used in comformation
$format = na;

#get quotes from Yahoo API
$quote = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=" . $ticker . "&f=" . $format . "&e=.csv");
$data = explode( ',', $quote);

#pull user balance from database
$balance = $currentUser->get("balance");

#make sure the stock exists
if ($data[0] != "N/A" && $quantity > 0) {
  $currPrice = $data[1];
  $remainingBalance = $balance - $currPrice*$quantity;

  if( ($remainingBalance) > 0 ) {
    $stocks = $currentUser->get("shares");

    if(isset($stocks) && array_key_exists($ticker, $stocks) ) {
      $stocks[$ticker] += $quantity;
    } else {
      $stocks[$ticker] = $quantity;
    }

    $currentUser->setAssociativeArray("shares", $stocks);
    $currentUser->set("balance", $remainingBalance);
    $currentUser->save();
    echo "stock brought!";
  }
} else {
  echo "Wrong ticker name!";
}
