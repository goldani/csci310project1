<?php
    require 'vendor/autoload.php';
    use Parse\ParseClient;
    date_default_timezone_set('America/New_York');
    ParseClient::initialize('W78hSNsME23VkGSZOD0JXn2XoM5Nf6GO41BgMqxE', 'H3EgW9gCr6wyP8MfL3Eobz1mWJMwydyp6N2prcVF', 'mRppu4ciMuqhNsTXHoeh329Za4ShOOc1F1NN0skD');

        use Parse\ParseUser;
        use Parse\ParseException;
        
        $currentUser = ParseUser::getCurrentUser();
        if ($currentUser) {
            /*header('Location: mainpage.html');*/
        } else {
            $username = $_POST["login-username"];
            $password = $_POST["login-password"];
            try {
                $user = ParseUser::logIn($username, $password);
                header('Location: mainpage.html');
                exit();

                
            } catch(ParseException $ex) {
                header('Location: index.php');
                //echo '<script>document.getElementById("error-box").innerHTML="Log in";</script>';
            }
        }
    ?>
