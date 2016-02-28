<?php
<<<<<<< HEAD
if (session_status() == PHP_SESSION_NONE) {
=======
if(session_status() == PHP_SESSION_NONE){
>>>>>>> 42285a8f55a11f3c8d78fa94d0f5e9fb67696a22
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>StockOverflow</title>
    <!-- tab bar icon not working -->
    <link rel="shortcut icon" type="image/ico" href="/favicon.ico">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
        require 'vendor/autoload.php';
        use Parse\ParseClient;
        use Parse\ParseUser;
        use Parse\ParseException;

        ParseClient::initialize('W78hSNsME23VkGSZOD0JXn2XoM5Nf6GO41BgMqxE', 'H3EgW9gCr6wyP8MfL3Eobz1mWJMwydyp6N2prcVF', 'mRppu4ciMuqhNsTXHoeh329Za4ShOOc1F1NN0skD');        	
        date_default_timezone_set('America/New_York');
        
        $currentUser = ParseUser::getCurrentUser();
        if ($currentUser) {
            echo '<script type="text/javascript">var logged_in=true;</script>';
        } else {
            echo '<script type="text/javascript">var logged_in=false;</script>';

        }

        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
            echo '<script type="text/javascript">var logged_in=true;</script>';
        }
        else{
            echo '<script type="text/javascript">var logged_in=false;</script>';
            // should encrypt through 256-bit one-way hash down the road
            if(isset($_POST["login-username"]) && isset($_POST["login-password"])){
                $username = $_POST["login-username"];
                $password = $_POST["login-password"];
                try {
                    $user = ParseUser::logIn($username, $password);
                    $_SESSION['loggedin'] = true;
                    $_SESSION['user'] = $user->getObjectID();
                    $_SESSION['username'] = $username;
                    echo '<script type="text/javascript">var logged_in=true;</script>';
                } catch(ParseException $ex) {
                    echo "Wrong credentials! ";
                    //use red letters under password field!
                }
            }
        }
		if(isset($_POST['buyStock'])){
			$ticker = $_POST["buySell-stockTicker"];
			$companyName = $_POST["buySell-companyName"];
			$quantity = $_POST["buySell-quantity"];
			$_SESSION['user']->buyStock($ticker, $companyName, $quantity);
		}
		else if(isset($_POST['sellStock'])){
			$ticker = $_POST["buySell-stockTicker"];
			$companyName = $_POST["buySell-companyName"];
			$quantity = $_POST["buySell-quantity"];
			$_SESSION['user']->sellStock($ticker, $companyName, $quantity);
		} 

		# timeout functionality. currently set to 10 seconds for testing
		if(isset($_SESSION['loggedin']) && time() - $_SESSION['timestamp'] > 10){
			unset($_SESSION['username'], $_SESSION['password'], $_SESSION['timestamp']);
			$_SESSION['loggedin'] = false;
			echo '<script type="text/javascript">var logged_in=false;</script>';
		} 
		else {
			$_SESSION['timestamp'] = time();
		}
    ?>
    <div class="overall-wrapper">
	    <div class="header">
            <a href=""><img src="img/so-logo.png" width=20% height=auto></a>
            <a href="logout.php" id="logout">Logout</a>
	    </div>

	    <div class="content login-content" id="login-content">
	    	<div class="widget-box login-box">
	    		<form action="" method="post">
			    	<input id="login-username" class="login-field" type="text" name="login-username" placeholder="Username" required autofocus>
			    	<input id="login-password" class="login-field" type="password" name="login-password" placeholder="Password" required>

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
        <div class="content main-content" id="main-content">
            <div class="column-left">
                <div class="portfolio">
					<h3>Portfolio</h3>
					<ul>
						<li>FB</li>
						<li>GOOG</li>
						<li>AAPL</li>
					</ul>
                </div>
				<br>
                <div class="buySell">
                    <form action="buySell.php" method="post">
						<input id="buySell-stockTicker" class="buySell-field" type="text" name="buySell-stockTicker" placeholder="Stock Ticker" pattern="[A-Za-z]{1,5}" maxlength="5" required autofocus><br>
						<input id="buySell-companyName" class="buySell-field" type="text" name="buySell-companyName" placeholder="Company Name" required><br>
						<input id="buySell-quantity" class="buySell-field" type="number" min="1" name="buySell-quantity" placeholder="Quantity" required><br>
						<div class="button-wrapper">
							<button type="submit" id="buyStock" name="buyStock" class="button-buySell">Buy</button>
							<button type="submit" id="sellStock" name="sellStock" class="button-buySell">Sell</button>
						</div>
                    </form>
                </div>
            </div>
            <div class="column-center">
                <div class="searchBar">
                    <form action="" method="post">
                        <input id="searchInput" class="searchBar" type="text" name="searchInput" placeholder="Search by stock ticker symbol...">
                    </form>
                </div>
                <div class="graph">
					<canvas id="myChart" width="400" height="400"></canvas>
                </div>
                <div class="infoBox">

                </div>
            </div>
            <div class="column-right">
                <div class="watchlist">
					<h3>Watchlist</h3>
					<ul>
						<li>TSLA</li>
						<li>TWTR</li>
					</ul>
                </div>
            </div>
        </div>
    </div>
    <script src="js/Chart.js"></script>
    <script type="text/javascript">
        if(logged_in){
            var loginContent = document.getElementById("login-content");
            var mainContent = document.getElementById("main-content");
            loginContent.style.display = "none";
            mainContent.style.display = "block";
        }
		else{
            var loginContent = document.getElementById("login-content");
            var mainContent = document.getElementById("main-content");
            loginContent.style.display = "block";
            mainContent.style.display = "none";
		}
    </script>
</body>
</html>
