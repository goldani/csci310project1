<?php

	require 'vendor/autoload.php';
    use Parse\ParseClient;
    ParseClient::initialize('W78hSNsME23VkGSZOD0JXn2XoM5Nf6GO41BgMqxE', 'H3EgW9gCr6wyP8MfL3Eobz1mWJMwydyp6N2prcVF', 'mRppu4ciMuqhNsTXHoeh329Za4ShOOc1F1NN0skD');        	
    
    date_default_timezone_set('America/New_York');
	
	// should encrypt through 256-bit one-way hash down the road
	$username = $_POST["login-username"];
	$password = $_POST["login-password"];

	use Parse\ParseUser;

	try {
		$user = ParseUser::logIn($username, $password);
		echo $username . " has logged in.";
	} catch(ParseException $ex) {
		echo "   ";
	}

	echo "inside";
?>
