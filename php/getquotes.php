<?php
$format = "snap2op";

$ticker = $_GET['ticker'];

$quote = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=" . $ticker . "&f=" . $format . "&e=.csv");
$data = explode( ',', $quote);

$name = NULL;
$price = NULL;
$percent = NULL;
$openingPrice = NULL;
$prevClosingPrice = NULL;

if (count($data) == 7) {
	$ticker = substr($data[0], 1, -1);
	$name = substr($data[1] . $data[2], 1, -1);
	$price = "$".$data[3];
	$percent = substr($data[4], 1, -2);
	$openingPrice = "$".$data[5];
	$prevClosingPrice = "$".$data[6];
} else {
	$ticker = substr($data[0], 1, -1);
	$name = substr($data[1], 1, -1);
	$price = "$".$data[2];
	$percent = substr($data[3], 1, -2);
	$openingPrice = "$".$data[4];
	$prevClosingPrice = "$".$data[5];

}
str_replace('"', "", $percent);
$results = $ticker . "_" . $name . "_" . " " . "_" . $price . "_" . $percent
 	. "_" . $openingPrice . "_" . $prevClosingPrice . "\n";
echo $results;
?>
