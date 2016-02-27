<?php
	class Stock {
		private $tickerSymbol;
		private $companyName;
		private $currentPrice;
		private $closingPrices;

		public function __construct ($tickerSymbol, $companyName, $currentPrice, $closingPrices) {
			$this->$tickerSymbol = $tickerSymbol;
			$this->$companyName = $companyName;
			$this->$currentPrice =  $currentPrice;
			$this->$closingPrices = $closingPrices;
		}

		public function computePercentChange() {
			
		}
	}
?>