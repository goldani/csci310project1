<?php
private function populateStocks($stocksID) {

  $query = new ParseQuery("Stock");
  foreach ($stocksID as $stockID) {
    try {

      $stock = $query->get($stockID);
      $stocks[$stock->get("tickerSymbol")] = $stock;
    } catch (ParseException $ex) {
      echo "error popolating stocks array with a spscific objectID";
    }
  }
  return $stocks;
}

?>
