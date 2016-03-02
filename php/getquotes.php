<?php
$format = "op";
$ticker = $_GET['ticker'];
$quote = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=" . $ticker . "&f=" . $format . "&e=.csv");
$data = explode( ',', $quote);

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
?>
