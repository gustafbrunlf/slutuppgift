<?php

	require_once("functions.php");

	$session = checkSession();

	if (!$session) {
		$_SESSION["error"] = "You need to log in";
		header("Location: login.php");
		die;

	}

	$userid   = $_SESSION["userdata"]["id"];
	$username = $_SESSION["userdata"]["username"];
	
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

	header('Location: '.$_SERVER['HTTP_REFERER']);
	die;
