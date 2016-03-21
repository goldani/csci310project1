<?php

function sell($ticker, &$currentStocks, $quantity, &$currentBalance, $price){
  $success = false;

  if(is_numeric($ticker)){
    return false;
  }

  if ($price != "N/A" && is_numeric ($quantity) && $quantity > 0) {

    if (array_key_exists($ticker, $currentStocks) && $currentStocks[$ticker]-$quantity >= 0) {
      $currentStocks[$ticker] -= $quantity;
      $currentBalance = $currentBalance + $price*$quantity;
      return true;
    } else {
      return false;
    }
  } else {
    return false;
  }
}

function buy($ticker, &$currentStocks, $quantity, &$currentBalance, $price){
  $success = false;

  if(is_numeric($ticker)){
    return false;
  }

  if ($price != "N/A" && is_numeric ($quantity) && $quantity > 0) {
    $remainingBalance = $currentBalance - $price*$quantity;
    if( ($remainingBalance) > 0 ) {

      if(isset($currentStocks) && array_key_exists($ticker, $currentStocks) ) {
        $currentStocks[$ticker] += $quantity;
      } else {
        $currentStocks[$ticker] = $quantity;
      }

      $currentBalance = $remainingBalance;
      return true;


    } else {
      return false;
    }
  } else {
    return false;
  }

}

?>