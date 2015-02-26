<?php

	require_once("functions.php");

	$session = checkSession();

	if (!$session) {
		
		$_SESSION["error"] = "You need to log in";
		header("Location: index.php");
		die;

	}

	$userid = $_SESSION["userdata"]["id"];

	if (isset($_POST["userid"])) {
		
		$followid = $_POST["userid"];

		$check = checkFollower($userid, $followid);

		if (!$check) {
			
			followUser($userid, $followid);

		} else {

			unFollowUser($userid, $followid);

		}

	}

	header('Location: '.$_SERVER['HTTP_REFERER']);
	die;