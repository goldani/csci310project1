<?php

//-----------------------------------------------------
// The front end Javascript will call buy.php with ?ticker="TICKERNAME"
//  &quantity=SOMENUMBER&action="BUYORSELL"
//
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
  echo "eror getting current user or not logged in!";
  exit();
}

#load the ticker to buy and quantity
$ticker = $_GET['ticker'];
$quantity = $_GET['quantity'];
$action = $_GET['action'];
#in order to buy a stock, we need to know current price. compant name tag is used in comformation
$format = na;

#get quotes from Yahoo API
$quote = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=" . $ticker . "&f=" . $format . "&e=.csv");
$data = explode( ',', $quote);



#make sure the stock exists
if ($data[0] != "N/A" && $quantity > 0) {

  #calculate remainning balance to determine wheather user can buy
  $currPrice = $data[1];
  $balance = $currentUser->get("balance");

  $actionConstant = ($action == "buy") ? -1 : 1;

  $remainingBalance = $balance + $currPrice*$quantity*$actionConstant;

  if( ($remainingBalance) > 0 ) {
    $stocks = $currentUser->get("shares");

    if ($action == "buy") {
      if(isset($stocks) && array_key_exists($ticker, $stocks) ) {
        $stocks[$ticker] += $quantity;
      } else {
        $stocks[$ticker] = $quantity;
      }
      echo "Stock brought";
    } else {
      #if sell, check can sell or not then echo result and exit
      if ($stocks[$ticker]-$quantity >= 0 && array_key_exists($ticker, $stocks)) {
        $stocks[$ticker] -= $quantity;
        echo "Stock sold";
      } else {
        echo "Cannot sell more than user have or sell stocks user do not own";
        exit();
      }
    }


    $currentUser->setAssociativeArray("shares", $stocks);
    $currentUser->set("balance", $remainingBalance);
    $currentUser->save();

  } else {
    echo "Insufficient balance";
  }
} else {
  echo "Wrong ticker name or non-positive quantiry";
}
