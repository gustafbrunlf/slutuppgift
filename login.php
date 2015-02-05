<?php

	$error = "";

	session_start();

	if (isset($_SESSION["userdata"])) {

	    header("Location: profile.php");

	}

	if (isset($_SESSION["error"])) {

	   $error = $_SESSION["error"];

	   unset($_SESSION["error"]);

	}

?>

<!DOCTYPE html>

<html lang="en">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>What's cooking?</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>

  </head>

	<body>

		<div class="wrapper">
		
			<div class="kojk">

				<h1>Log in to <span>What's cooking?</span> or:<br>
				<a href="register.php">Register here</a></h1>
	
				<form action="checklogin.php" method="POST">
					
					<input type="text" placeholder="Username" name="username">
					<input type="password" placeholder="Password" name="password">
					<button type="submit">Logi<span>n</span></button><br>

				</form>
				
				<div class="loginerror"><p><?= $error; ?></p></div>
	
			</div>

		</div>

	</body>

</html>
