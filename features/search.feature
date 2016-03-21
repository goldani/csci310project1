Feature: Search stock

	Scenario: Stock result appeared successfully when input is ticker symbol
		Given user is logged in:
			|username|zhongyag@usc.edu|
			|password|zg|
		When the following ticker symbol is searched:
			|Ticker|SEED|
		Then searched stock should be in the drop down
