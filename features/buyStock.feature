Feature: Buy stock

	Scenario: Stock successfully bought when stock market open
		Given user is logged in on the dashboard:
			|username|renachen@usc.edu|
			|password|rc|
		When the following stock information is input:
			|Ticker|SEED|
			|Quantity|1|
		And the time in EST is between 9am and 4pm
		Then balance and stock quantity should update
