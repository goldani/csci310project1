<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | StockOverflow</title>
    <!-- bottom icon not working -->
    <link rel="shortcut icon" type="image/ico" href="/favicon.ico">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
        require 'vendor/autoload.php';
        use Parse\ParseClient;
        ParseClient::initialize('W78hSNsME23VkGSZOD0JXn2XoM5Nf6GO41BgMqxE', 'H3EgW9gCr6wyP8MfL3Eobz1mWJMwydyp6N2prcVF', 'mRppu4ciMuqhNsTXHoeh329Za4ShOOc1F1NN0skD');        	
        date_default_timezone_set('America/New_York');
        use Parse\ParseUser;
        use Parse\ParseException;
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
    ?>
    <div class="overall-wrapper">
	    <div class="header">
			<a href=""><img src="img/so-logo.png" width=20% height=auto></a>
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
            <div class="searchBar">
                <p>Search bar</p>
            </div>
            <div class="graph">
            </div>
            <div class="portfolio">
            </div>
        </div>
        <!--
	    <footer>
	    <p><small>This is the work of college students.</small></p>
	    <br>
	    <br>
	    <p><small>For more information, <a href="mailto:halfond@usc.edu" target="_top">email</a> or <a href="tel:12137401239">call</a> Professor Halfond.</small></p>
	    </footer>
        -->
    </div>
    <script src="js/Chart.js"></script>
    <script type="text/javascript">
        if(logged_in){
            var loginContent = document.getElementById("login-content");
            var mainContent = document.getElementById("main-content");
            loginContent.style.display = "none";
            mainContent.style.display = "block";
        }
    </script>
</body>
</html>
