<?php
    include 'vendor/autoload.php';
    use Parse\ParseClient;
    use Parse\ParseUser;
    use Parse\ParseException;
    date_default_timezone_set('America/New_York');
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
        ParseClient::initialize('W78hSNsME23VkGSZOD0JXn2XoM5Nf6GO41BgMqxE', 'H3EgW9gCr6wyP8MfL3Eobz1mWJMwydyp6N2prcVF', 'mRppu4ciMuqhNsTXHoeh329Za4ShOOc1F1NN0skD');   
    }
    $currentUser = ParseUser::getCurrentUser();
    if ($currentUser) {
        header('Location: /mainpage.html');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | StockOverflow</title>
    <!-- tab bar icon not working -->
    <link rel="shortcut icon" type="image/ico" href="/favicon.ico">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="overall-wrapper">
	    <div class="header">
            <a href="/"><img src="img/so-logo.png" id="logo"></a>
	    </div>
        <div class="content login-content">
            <div class="widget-box login-box">
                <form action="" method="post" id="form1">
                    <p id="error-box"></p>
                    <input id="login-username" class="login-field" type="email" name="login-username" placeholder="Email" required autofocus>
                    <input id="login-password" class="login-field" type="password" name="login-password" placeholder="Password" required>
                    <div class="button-wrapper">
                        <input id="login-submit" class="button submit-button" type="submit" value="Login" onclick="submitForm('login.php')"/>
                        <input id="forgot-password" class="button submit-button" type="submit" value="Forgot Password" formnovalidate="formnovalidate" onclick="submitForm('reset.php')"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
		function submitForm(action)
		{
			document.getElementById('form1').action = action;
			document.getElementById('form1').submit();
		}
    </script>
</body>
</html>
