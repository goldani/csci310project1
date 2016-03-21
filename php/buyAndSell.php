<?php

//-----------------------------------------------------
// The front end Javascript will call buy.php with ?ticker="TICKERNAME"
//  &quantity=SOMENUMBER&action="BUYORSELL"
//
//-----------------------------------------------------

#initialize databse connection
include 'buyAndSellFunctions.php';
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

#load the ticker to buy&make it upper caseand quantity
$ticker = $_GET['ticker'];
$ticker = strtoupper($ticker);
$quantity = $_GET['quantity'];

$action = $_GET['action'];
$format = "na";

#get quotes from Yahoo API
$quote = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=" . $ticker . "&f=" . $format . "&e=.csv");
$data = explode( ',', $quote);


  #calculate remainning balance to determine wheather user can buy
  # little trick here to skip pos in array until element is numeric in case company has , in its name
  $currPrice = $data[count($data) - 1];
  $balance = $currentUser->get("balance");

  $stocks = $currentUser->get("stocks");

//////////////////////////// all info retreaved from database and API \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

  if ($action == "sell") {

    if(sell($ticker, $stocks, $quantity, $balance, $currPrice) == true){

      $currentUser->setAssociativeArray("stocks", $stocks);
      $currentUser->set("balance", $balance);
      $currentUser->save();

      echo "Stock sold";

    } else {
      echo "Fail";
    }

  } else {
    $actionConstant = -1;

    if(buy($ticker, $stocks, $quantity, $balance, $currPrice) == true){

      $currentUser->setAssociativeArray("stocks", $stocks);
      $currentUser->set("balance", $balance);
      $currentUser->save();

      echo "Stock bought";
    } else {
      echo "Fail";
    }

  }

?>