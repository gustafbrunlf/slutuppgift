<?php

	require_once("functions.php");

	$userid   = $_SESSION["userdata"]["id"];
	$username = $_SESSION["userdata"]["username"];

	// $comment = "";

	// if (isset($_POST["comment"])) {

	// 		$comment = $_POST["comment"];
	// 		$id = $_POST["id"];

	// 		if ($comment == "") {

	// 	 		$_SESSION["error"] = "Please fill in a message";

	// 	 	} else {

	// 	 		$username = substr_replace($username, "@$username", 0);

	// 	 		createComment($comment, $userid, $username, $id);

	// 	 	}

	// }
