<?php
	//$ticker = $_GET['ticker'];
	$ticker = 'AMZN';
	$format = 'SNAP2';
	$quote = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=" . $ticker . "&f=" . $format . "&e=.csv");
	$data = explode(',', $quote);
	for ($i = 0; $i < count($data); $i++) {
	  $result = $data[$i];
	  echo $result . "\n";
	}
?>
