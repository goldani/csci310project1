<?php
	#header("Location: /");
	#$currentBalance = $_SESSION['user']->getCurrentBalance()
    $ticker = $_POST["buySell-stockTicker"];
    $companyName = $_POST["buySell-companyName"];
    $quantity = $_POST["buySell-quantity"];
	#look up stock and confirm it is valid
	#if valid retrieve current price

	#also check current time to see if market is open
    if(isset($_POST['buyStock'])){
        #buy stock with above data
		#but first check currentBalance is sufficient
    }
    else{
        #sell stock with above data
    } 
	#need to update currentBalance
?>
