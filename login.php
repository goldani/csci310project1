<?php

	require 'vendor/autoload.php';
    use Parse\ParseClient;
    ParseClient::initialize('W78hSNsME23VkGSZOD0JXn2XoM5Nf6GO41BgMqxE', 'H3EgW9gCr6wyP8MfL3Eobz1mWJMwydyp6N2prcVF', 'mRppu4ciMuqhNsTXHoeh329Za4ShOOc1F1NN0skD');        	
    
    date_default_timezone_set('America/New_York');
	
	// should encrypt through 256-bit one-way hash down the road
	$username = $_POST["login-username"];
	$password = $_POST["login-password"];

	use Parse\ParseUser;
	use Parse\ParseException;
	if (empty($username) || empty($password)) {
		echo "Enter both username and password";
		// use red text above username field
	} else {
		try {
			$user = ParseUser::logIn($username, $password);
			echo $username . " has logged in.";
			//go to home
		} catch(ParseException $ex) {
			echo "Wrong credentials! ";
			//use red letters under password field!
		}
	}
?>
