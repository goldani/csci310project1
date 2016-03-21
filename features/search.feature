Feature: Search stock

	Scenario: Stock result appeared successfully when input is ticker symbol
		Given user is logged in:
			|username|zhongyag@usc.edu|
			|password|zg|
		When the following stock is searched:
			|Stock|BABA|
		Then searched stock should be in the drop down:
			|FullName|BABA - Alibaba Group Holding Limited|

	Scenario: Stock result appeared successfully when input is company name
		When the following stock is searched:
			|Stock|Apple Inc.|
		Then searched stock should be in the drop down:
			|FullName|AAPL - Apple Inc.|

	Scenario: Stock result do not appear when input is wrong
		When the following stock is searched:
			|Stock|AAPLE|
		Then drop down should be empty:
		Then close window
