 <?php

//This parsing of the CSV happens when the user provides a file
$row = 1;
//get file from html
//$file = ;

if (($handle = fopen("filename", "r")) !== FALSE) {
  while (($stocksInfo = fgetcsv($handle, 1000, ",")) !== FALSE) {
    $size = count($stocksInfo);
    echo '------------------------------'. "\n";
    $row++;

    //Stock information from API
	$symbol = $stocksInfo[0];
	$stockName = $stocksInfo[1];
	$currentPrice = $stocksInfo[2];
	$previousClose = $stocksInfo[3];
	$open = $stocksInfo[4];
	$percentChange = $stocksInfo[5];
	$oneYear = $stocksInfo[6];
	$fiftyTwoWeek = $stocksInfo[7];

	echo 'Symbol: ' . $symbol . "\n";
	echo 'Company Name: ' . $stockName. "\n";
	echo 'Curent Price: ' . $currentPrice . "\n";
	echo 'Previous Close Price: ' . $previousClose . "\n";
	echo 'Open Price: ' . $open . "\n";
	echo 'Percent Change: ' . $percentChange . "\n";
	echo 'Price a year ago: ' . $oneYear . "\n";
	//echo $fiftyTwoWeek . "\n";

	//create an object for each different stock that will come on the
  }
  fclose($handle);
}

?>
