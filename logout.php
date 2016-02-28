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
	ParseUser::logOut();
	header('Location: /');
?>
