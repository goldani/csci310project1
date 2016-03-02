<?php

$symbol = "ARGS";//post from html

if (($handle = fopen("http://ichart.finance.yahoo.com/table.csv?s=" . $symbol, "r")) !== FALSE) {
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

    $date = $data[0];
    $closingPrice = $data[4];
    echo "Date: " . $date . " Price: " . $closingPrice . "\n";

//first from while are just headers

  }
}



?>
