<?php

Class User {

	private $username;
	private $password;
	private $balance;
	private $stocks;
	private $amounts;

	public function __construct ($username, $password){
		$this->$username = $username;
		$this->$password = $password;

		#get starting balance from Parse database
		$query = new ParseQuery("User");
		$query->equalTo("username", $username);
		try{
			$currUser = $query->first();
			$this->$balance = $currUser->get("balance");
			$stocksID = $currUser->get("stocks");
			if (isset($stocksID)) {
				$this->$stocks = populateStocks($stocksID);
			}
			$this->$amounts = $currUser->get("shares");
		} catch (ParseException $ex) {
			echo "error popolating stocks array with a spscific objectID";
		}
	}

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

	public function sellStock($ticker, $quantity){
		#look up stock and confirm it is valid
		#check current time to see if market is open

		if(!isset($stocks)){
			//no stocks to sell
			echo 'Stock sold';
		}

	}

	public function importCSVFile(){

	}

	private function getQuote($ticker, $format) {
		$data = file_get_contents("http://finance.yahoo.com/d/quotes.csv?s=$ticker&f=$format&e=.csv");
		$result = explode( ',', $data);

		return $result;
	}

	#popolates user's $stocks array with Stock objects from database
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

	#
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

}
