<!DOCTYPE html>
<html lang="en">
<head>
    <title>StockOverflow</title>
    <!-- tab bar icon not working -->
    <link rel="shortcut icon" type="image/ico" href="/favicon.ico">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="overall-wrapper">
	    <div class="header">
            <a href="/"><img src="img/so-logo.png" width=20% height=auto></a>
	    </div>

        <div class="content login-content">
            <div class="widget-box login-box">
                
                <form action="login-authentication.php" method="post">
                    <p id="error-box"></p>
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



    </div>

	    
</body>
</html>
