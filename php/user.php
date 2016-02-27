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
		//$this->$balance = 10000;
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

	public function sendResetPasswordLink(){

	}

	public function resetPassword($oldPassword){

	}

	public function importCSVFile(){

	}
}