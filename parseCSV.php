 <?php


$row = 1;
$symbolSearched = APPL;
if (($handle = fopen("http://finance.yahoo.com/d/quotes.csv?s=AAPL+GOOG+MSFT&f=snapop2t8w", "r")) !== FALSE) {
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
  }
  fclose($handle);
}

?>