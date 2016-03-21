Feature: Display stock info

	Scenario: Stock info should be displayed at lower right corner of the screen when clicked from left side
		Given user is logged in to dash:
			|username|zhongyag@usc.edu|
			|password|zg|
		When a stock from left side is clicked:
		Then the clicked stock's info should be displayed:
