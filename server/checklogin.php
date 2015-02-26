<?php

	require_once("functions.php");

	$session = checkSession();

	if ($session) {
		
		header("Location: index.php");
		die;

	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		$username = $_POST["username"];
		$password = $_POST["password"];

		$user = validateUser($username, md5($password));

		if ($user) {

			createSession($user);

			header("Location: ../index.php");
			die;

		} else {

	 	unset($_SESSION["userdata"]);
	 	$_SESSION["error"] = "Invalid log in";
	 	header("Location: ../login.php");
	 	die;

	   }

	}


