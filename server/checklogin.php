<?php

	require_once("data.php");

	$session = checkSession();

	if ($session) {
		
		header("Location: profile.php");
		die;

	}

		if ($_SERVER["REQUEST_METHOD"] == "POST") {

				$username = $_POST["username"];
				$password = $_POST["password"];

				#$user = validateUser($_POST["username"], md5($_POST["password"]));
				$user = validateUser($username, $password);

				if ($user) {

					createSession($user);

					header("Location: ../profile.php");
					die;

				} else {

			 	unset($_SESSION["userdata"]);
			 	$_SESSION["error"] = "Invalid log in";
			 	header("Location: ../login.php");
			 	die;

			   }

		}


