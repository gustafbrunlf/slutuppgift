<?php 

	session_start();

	if (!isset($_SESSION["userdata"])) {

		$_SESSION["error"] = "You're not logged in";
		header("Location: login.php");
		die;

	}

	require_once("functions.php");
	require_once("uploadpic.php");
	require_once("searchfield.php");


	$userid   = $_SESSION["userdata"]["id"];
	$username = $_SESSION["userdata"]["username"];

	$guestbook = getPosts($userid);
	$getpic    = getPicPath($userid);
	$following = followingUsers($userid);

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
    <link rel="stylesheet" href="css/main.css">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
  </head>
 	
	<body>

		<div id="container">
			
			<header>
				
				<h3 class="logout"><a href="logout.php">Log out</a></h3>
				<h3 class="update"><a href="profile.php">Home</a></h3>
				
				<h1><a href="profile.php">What's cooking?</a></h1>

				<form class="search" action="searchresult.php?search=" method="GET">

					<input type="text" name="search" id="searchinput">
					<button type="submit" id="searchbutton">search</button>

				</form>

				<?= $search; ?>

			</header>

			<div class="inputwrapper">

				<div class="editprofile">

					<?php 

						foreach ($getpic as $value) {

							print '<img class="profilepic" src="' .Sanitize($value["picpath"]). '">';

						}

						print '<h1 class="userinfo">' .$username. '</h1>';

					?>

					<form enctype="multipart/form-data" action="editprofile.php" method="POST">

						<input class="inputupload" type="file" name="upload">
						<input class="uploadbutton" type="submit" value="Upload">

					</form>

					<span class="error"><?= $error; ?></span>

				</div>	

			</div>	

		</div>

	</body>

</html>