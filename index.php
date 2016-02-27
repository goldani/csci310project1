<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | StockOverflow</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="overall-wrapper">
	    <div class="header">
	   		<h1>StockOverflow</h1>
	    </div>

	    <div class="content login-content">
	    	<div class="widget-box login-box">
	    		<form>
		    		<p>Username</p>
			    	<input id="login-username" class="login-field" type="text">
			    	<p>Password</p>
			    	<input id="login-password" class="login-field" type="text">

			    	<div class="button-wrapper">
			    		<input id="login-submit" class="button submit-button" type="submit" value="Login">
			    		<button id="forgot-password" class="button">Forgot Password</button>
			    	</div>
			    	<div class="forget-password-field">
			    		<p>Please enter your email</p>
			    		<input id="input-email" class="login-field" type="text" value="someone@somewhere.com">
			    	</div>
			    </form>
	    	</div>
	    </div>

	    <footer>
	    <p><small>This is the work of college students.</small></p>
	    <br>
	    <br>
	    <p><small>For more information, contact Professor Halfond</small></p>
	    </footer>
    </div>
















	<?php
		require 'vendor/autoload.php';
        	use Parse\ParseClient;
                ParseClient::initialize('W78hSNsME23VkGSZOD0JXn2XoM5Nf6GO41BgMqxE', 'H3EgW9gCr6wyP8MfL3Eobz1mWJMwydyp6N2prcVF', 'mRppu4ciMuqhNsTXHoeh329Za4ShOOc1F1NN0skD');        	
                use Parse\ParseObject;
        	date_default_timezone_set('America/New_York');
                // check if stock exists before creating and saving
                $stock = new ParseObject('Stock');
                $stock->set('tickerSymbol', 'AAPL');
                $stock->set('companyName', 'Apple');
                $stock->set('currentPrice', 24);
                $stock->setArray('closingPrices', [23, 25, 32, 33, 40, 23]);
        	$stock->save();
	?>

	<!-- Load javascript here -->
	<script src="js/Chart.js"></script>
</body>
</html>
