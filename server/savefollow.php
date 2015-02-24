<?php

	session_start();

	require_once("data.php");

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