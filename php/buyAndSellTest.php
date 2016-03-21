<?php

include 'buyAndSellFunctions.php';

/*
This testing is using the buyAndSellFunctions implemented for the process of buying and selling, 
this functions are isolated from the database and API and thus assume the following, 
which is NOT part of unit testing (need the API):
	- Stock provided exists, that is, the ticker is legitimate
	- Price provided is real
*/
class BuyAndSellTest extends PHPUnit_Framework_TestCase {

	public function testNotEnoughBalanceToBuyStock(){
		$ticker = "APPL";
		$stocks = array(
    	"N/A" => "N/A",
		);
		$quantity = 1;
		$balance = 0;
		$price = 102.10;

		$this->assertEquals(false, buy($ticker, $stocks, $quantity, $balance, $price));
	}


	public function testEnoughBalanceToBuyStock(){
		$ticker = "APPL";
		$stocks = array(
    	"AMZN" => "3",
		);
		$quantity = 1;
		$balance = 200.0;
		$price = 102.10;

		$this->assertEquals(true, buy($ticker, $stocks, $quantity, $balance, $price));

	}

	public function testStockNotOwnedWhenBoughtSoAddToArray(){
		$ticker = "APPL";
		$stocks = array(
    	"AMZN" => "3",
		);
		$quantity = 1;
		$balance = 200.0;
		$price = 102.10;

		$success = buy($ticker, $stocks, $quantity, $balance, $price);
		$this->assertEquals(true, $success);
		$this->assertEquals(2, count($stocks));

	}

	public function testStockAlreadyOwnedWhenBoughtSoJustIncrementAmount(){
		$ticker = "AAPL";
		$stocks = array(
    	"AAPL" => "3",
		);
		$quantity = 1;
		$balance = 200.0;
		$price = 102.10;

		$success = buy($ticker, $stocks, $quantity, $balance, $price);
		$this->assertEquals(true, $success);
		$this->assertEquals(1, count($stocks));
		$this->assertEquals(4, $stocks[$ticker]);
	}

	public function testStockToSellNotOwnedSoNothingHappens(){
		$ticker = "AAPL";
		$stocks = array(
    	"AMZN" => "1",
		);
		$quantity = 1;
		$balance = 200.0;
		$price = 102.10;

		$this->assertEquals(false, sell($ticker, $stocks, $quantity, $balance, $price));
	}

	public function testStockToSellOwenedAndSold(){
		$ticker = "AAPL";
		$stocks = array(
    	"AAPL" => "1",
		);
		$quantity = 1;
		$balance = 200.0;
		$price = 102.10;

		$this->assertEquals(true, sell($ticker, $stocks, $quantity, $balance, $price));
		$this->assertEquals(0, $stocks[$ticker]);
	}

	public function testQuantityProvidedIsZeroOrNegative(){
		$ticker = "APPL";
		$stocks = array(
    	"N/A" => "N/A",
		);
		$quantity = 0;
		$balance = 200;
		$price = 102.10;

		$this->assertEquals(false, buy($ticker, $stocks, $quantity, $balance, $price));
		$this->assertEquals(false, sell($ticker, $stocks, $quantity, $balance, $price));

		$quantity = -1;

		$this->assertEquals(false, buy($ticker, $stocks, $quantity, $balance, $price));
		$this->assertEquals(false, sell($ticker, $stocks, $quantity, $balance, $price));
	}

	public function testQuantityProvidedIsNotNumberic(){
		$ticker = "APPL";
		$stocks = array(
    	"N/A" => "N/A",
		);
		$quantity = "uio";
		$balance = 200;
		$price = 102.10;

		$this->assertEquals(false, buy($ticker, $stocks, $quantity, $balance, $price));
		$this->assertEquals(false, sell($ticker, $stocks, $quantity, $balance, $price));
	}

	public function testTickerNameProvidedIsNotAlpha(){
		$ticker = "1234";
		$stocks = array(
    	"N/A" => "N/A",
		);
		$quantity = "uio";
		$balance = 200;
		$price = 102.10;

		$this->assertEquals(false, buy($ticker, $stocks, $quantity, $balance, $price));
		$this->assertEquals(false, sell($ticker, $stocks, $quantity, $balance, $price));
	}
}

?>