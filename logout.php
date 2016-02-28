<?php
	session_start();
	ParseUser::logOut();
	session_destroy();
	header('Location: /');
	exit;
?>
