<?php
	use Parse\ParseUser;
	ParseUser::logOut();
	header('Location: /');
?>
