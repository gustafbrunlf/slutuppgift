<?php

	session_start();

	require_once("functions.php");

	$userid   = $_SESSION["userdata"]["id"];
	$username = $_SESSION["userdata"]["username"];

	$comment = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if (!empty($_POST["comment"])) {

				$comment = $_POST["comment"];
				$id = $_POST["id"];

		 		$username = substr_replace($username, "@$username", 0);

		 		createComment($comment, $userid, $username, $id);

		} else {

			$_SESSION["error"] = "Please make a comment";

		}

	}

	header('Location: '.$_SERVER['HTTP_REFERER']); // Lägg till if-satser
	die;
