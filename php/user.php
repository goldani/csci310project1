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
		$query = new ParseQuery("accountBalance");
		$query->equalTo("username", $username);
		$results = $query->find();
		#echo "Successfully retrieved " . count($results) . " balances.";
		#there should be only one balance for each user
		$this->balance = $results[0];
	}

	public function buyStock (){
		if(!isset($stocks)){
			//create the array with the new stock info
			echo 'Stock bought';
		}

	}

	public function sellStock(){

		if(!isset($stocks)){
			//no stocks to sell
			echo 'Stock sold';
		} 

	}
	
	public function importCSVFile(){

	}
}