<?php

	require_once("functions.php");

	//$ttl = (10);

	session_start();

		if ($_SERVER["REQUEST_METHOD"] == "POST") {

				$user = getUser($_POST["username"], $_POST["password"]);

				if ($user) {

					createSession($user);

					header("Location: profile.php");

				} else {

			 	unset($_SESSION["userdata"]);
			 	$_SESSION["error"] = "Invalid log in";
			 	header("Location: login.php");

			   }

		}


