<?php 

	session_start();
	session_destroy();

	$name = session_name();

	setcookie($name, "", 1);

	header("Location: login.php");
	die;