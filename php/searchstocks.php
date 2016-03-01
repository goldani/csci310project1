<?php

include '../vendor/autoload.php';
use Parse\ParseClient;
use Parse\ParseQuery;
use Parse\ParseUser;
use Parse\ParseException;
date_default_timezone_set('America/New_York');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    ParseClient::initialize('W78hSNsME23VkGSZOD0JXn2XoM5Nf6GO41BgMqxE', 'H3EgW9gCr6wyP8MfL3Eobz1mWJMwydyp6N2prcVF', 'mRppu4ciMuqhNsTXHoeh329Za4ShOOc1F1NN0skD');
}

//get current text typed at search bar from javacript
$current = $_GET['ticker'];

$tickerQuery = new ParseQuery("Stock");
$tickerQuery->startsWith("ticker", $current);

$nameQuery = new ParseQuery("Stock");
$name = ucwords(strtolower($current));
$nameQuery->startsWith("name", $name);

$combinedQuery = ParseQuery::orQueries([$tickerQuery, $nameQuery]);
$combinedQuery->ascending("name");
$combinedQuery->limit(5);
$results = $combinedQuery->find();

$allResults = "";
for ($i=0; $i < count($results); $i++) {
  $result = $results[$i];
  $allResults .= $result->get("ticker") . " - " . $result->get("name") . "\n";
}

echo $allResults;

?>
