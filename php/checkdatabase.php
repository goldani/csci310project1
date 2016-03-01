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
$allResults = "";

$query = new ParseQuery("Stock");
$query->limit(10); // limit to at most 10 results
$query->startsWith("ticker", $current);
$results = $query->find();

for ($i=0; $i < count($results); $i++) {
  $result = $results[$i];
  $allResults .= $result->get("ticker") . " - " . $result->get("name") . "\n";
}

echo $allResults;

?>
