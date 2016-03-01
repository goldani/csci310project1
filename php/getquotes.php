<?php

$ticker = $_GET['ticker'];
$format = $_GET['format'];
$data = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=" . $ticker. "&f=" . $format . "&e=.csv");
echo $data;
?>
