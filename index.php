<!DOCTYPE html>
<html>
<head>
        <title>Root | StockOverflow</title>
</head>
<body>
        <h1>Root for StockOverflow</h1>
        <form action="login/index.html">
                <input type="submit" value="Login">
        </form>
        <form action="home/index.html">
                <input type="submit" value="Home">
        </form>

	<?php
		require 'vendor/autoload.php';
		use Parse\ParseClient;
		ParseClient::initialize('W78hSNsME23VkGSZOD0JXn2XoM5Nf6GO41BgMqxE', 'H3EgW9gCr6wyP8MfL3Eobz1mWJMwydyp6N2prcVF', 'mRppu4ciMuqhNsTXHoeh329Za4ShOOc1F1NN0skD');
		use Parse\ParseObject;
                date_default_timezone_set('America/New_York');
		$testObject = ParseObject::create("TestObject");
                $testObject->set("foo", "bar");
                $testObject->save();	
	?>
</body>
</html>
