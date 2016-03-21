Feature: Login authentication

	User must log in to account to access the rest of the website.

	Scenario: Successful login
		Given user is on login page
		Given the following existing user and password:
			|username|renachen@usc.edu|
			|password|rc|
		When user enters correct username and password
		Then the page should redirect to dashboard

	Scenario: Bad login
		Given user is on login page
		Given the following existing user and password:
			|username|renachen@usc.edu|
			|password|rc|
		When user enters incorrect password
		Then the page should stay on login
