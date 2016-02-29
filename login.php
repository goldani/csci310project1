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
        header('Location: /mainpage');
    } else {
        $username = $_POST['login-username'];
        $password = $_POST['login-password'];
        try {
            $user = ParseUser::logIn($username, $password);
            header('Location: /mainpage');
        } catch(ParseException $error) {
            header('Location: /');
        }
    }	
?>
