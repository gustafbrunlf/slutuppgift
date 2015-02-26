<?php
	
	$error = "";

	require_once("server/functions.php");

	$session = checkSession();

	if ($session) {

		header("Location: profile.php");
	    die;

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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>What's cooking?</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/login.css">

  </head>

	<body>

		<div class="wrapper">
		
			<div class="formwrapper">

				<h1>Log in to<br><span>What's cooking?</span><br>	or:<br>
				<a href="register.php">Register here</a></h1>
				
				<form action="server/checklogin.php" method="POST">
					
					<input type="text" placeholder="Username" name="username">
					<input type="password" placeholder="Password" name="password">
					<button type="submit">Logi<span>n</span></button><br>

				</form>
				
				<div class="loginerror"><p><?= $error; ?></p></div>
	
			</div>

		</div>

	</body>

</html>