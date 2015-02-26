<?php 
	
	require_once("functions.php");

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		$email    = $_POST["email"];
		$username = $_POST["username"];
	 	$password = $_POST["password"];

	 	if(validateEmail($email)){

		 	if (checkUsername($username)) {

	 			$_SESSION["error"] = "Username taken";

		 	} else {

	 			$userpath = substr(md5(rand()), 0, 7);

	 			$passwd = md5($password);

		 		createUser($username, $passwd, $email, $userpath);

				$_SESSION["error"] = "Registration completed, please log in!";

				header("Location: login.php");
				die;

		 	}

	 	} else {

	 		$_SESSION["error"] = "Invalid e-mail";

	 	}


 	}