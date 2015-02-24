<?php

	session_start();

	require_once("data.php");

		if ($_SERVER["REQUEST_METHOD"] == "POST") {

				$user = getUser($_POST["username"], $_POST["password"]);

				if ($user) {

					createSession($user);

					header("Location: ../profile.php");
					die;

				} else {

			 	unset($_SESSION["user"]);
			 	$_SESSION["error"] = "Invalid log in";
			 	header("Location: ../login.php");
			 	die;

			   }

		}


