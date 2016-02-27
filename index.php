<!DOCTYPE html>
<html>
<head>
    <title>Login | StockOverflow</title>
    <script src="Chart.js"></script>
</head>
<body>
    <h1>Login for StockOverflow</h1>
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
</body>
</html>
