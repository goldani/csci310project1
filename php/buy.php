<?php
public function buyStock ($ticker, $quantity){


  #TODO:check current time to see if market is open
  # either do it in frontend or backend

  #Get quote from Yahoo API with $ticker and na option(Company name and Current price)
  $result = getQuote($ticker, "na");

  #Make sure the stock exists
  if ($result[0] != "N/A" && $quantity > 0) {
    $currPrice = $result[1];
    if( ($balance - $currPrice*$quantity) > 0 ) {
      addStock($ticker, $quantiry);
    }
  } else {
    echo "Wrong ticker name!";
  }
}

private function addStock($ticker, $quantity) {
  #TODO discuss if we really need a Stock table in database

  #if the stock purchsed already in user's porfolio, updata amount
  # if not, create new stock&amount in $amounts and add stock to user's
  # $stocks array and update in database
  if (array_key_exists($ticker,$amounts)) {
    $amounts[$ticker] += $quantity;
  } else {
    #need know if we need Stock table or not
  }
}

 ?>
