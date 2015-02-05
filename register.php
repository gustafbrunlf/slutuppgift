<?php

	session_start();

	require_once("registeruser.php");

	$error = "";

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
    <link rel="stylesheet" href="css/register.css">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
  </head>

	<body>

		<div class="wrapper">
		
			<div class="formwrapper">

				<h1>Register: </h1>
				
				<form action="register.php" method="POST" name="registrationform">
				
					<input type="text" id="email" placeholder="E-mail" name="email" value="<?php if(isset($_POST['email'])){ print $_POST['email']; } ?>">
					<input type="text" id="username" placeholder="Username" name="username" value="<?php if(isset($_POST['username'])){ print $_POST['username']; } ?>">
					<input type="password" id="password" placeholder="Password" name="password" value="<?php if(isset($_POST['password'])){ print $_POST['password']; } ?>">
					<input type="password" id="password2" placeholder="Confirm password" name="password2" value="<?php if(isset($_POST['password2'])){ print $_POST['password2']; } ?>">
					<button type="submit" id="submit">Submi<span>t</span></button>

				</form>
				
				<div id="registererror"><p><?= $error; ?></p></div>
				
			</div>

		</div>

	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/register.js"></script>

	</body>

</html>