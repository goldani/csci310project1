<?php

$ticker = $_GET['ticker'];
$format = $_GET['format'];
// $ticker = "AAPL";
// $format = "na";
$data = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=" . $ticker. "&f=" . $format . "&e=.csv");
// // $result = explode( ',', $data);
//
echo $data;


//$localtime = localtime(time(), true);
//echo json_encode($localtime);


// var url = 'http://query.yahooapis.com/v1/public/yql';
// var startDate = '2016-02-22';
// var endDate = '2016-02-23';
// var data = encodeURIComponent('select * from yahoo.finance.historicaldata where symbol in ("YHOO","AAPL","GOOG","MSFT") and startDate = "' + startDate + '" and endDate = "' + endDate + '"');
// $.getJSON(url, 'q=' + data + "&env=http%3A%2F%2Fdatatables.org%2Falltables.env&format=json", callback);
?>
