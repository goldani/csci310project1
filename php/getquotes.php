<?php

private function getQuote($ticker, $format) {
  $data = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=" . $ticker. "&f=" . $format . "&e=.csv");
  $result = explode( ',', $data);

  return $result;
}

?>
