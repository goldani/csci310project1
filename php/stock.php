<?php

Class Stock {

	private $tickerSymbol;
	private $companyName;
	private $currentPrice;

	public function __construct ($tickerSymbol_, $companyName_, $currentPrice_){
		$this->$tickerSymbol = $tickerSymbol_;
		$this->$companyName = $companyName_;
		$this->$currentPrice =  $currentPrice_;
	}

	public function computePercentChange(){

	}

	public function computePredictedPrice(){
		
	}
}