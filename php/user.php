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
		$results = $query->first();
		#echo "Successfully retrieved " . count($results) . " balances.";
		#there should be only one balance for each user
		$this->balance = $results->get("balance");
		$this->stocks = populateStocks($results->get("stocks"));
	}

	public function buyStock ($ticker, $quantity){

		$result = getQuote($ticker, "na");

		$currPrice = $result[1];

		if( ($balance - $currPrice*$quantity) > 0 ) {
			addStock($ticker, $quantiry);
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

	}

}
