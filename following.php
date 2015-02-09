<?php 

	session_start();

	if (!isset($_SESSION["userdata"])) {

		$_SESSION["error"] = "You're not logged in";
		header("Location: login.php");
		die;

	}

	require_once("functions.php");
	require_once("searchfield.php");

	$userid   = $_SESSION["userdata"]["id"];
	$username = $_SESSION["userdata"]["username"];

	// Se över hur man ska få viewuser vänner följare and visas på following!
	// Spana in savecommentview

	$getpic    = getPicPath($userid);
	$following = followingUsers($userid);
	$followers = getFollowers($userid);

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

				<div class="profile profilefollow">

					<?php 

						foreach ($getpic as $value) {

							if(!$value["picpath"]){

								print '<img class="profilepic" src="profile/standard.jpg">';

							} else {

								print '<img class="profilepic" src="' .Sanitize($value["picpath"]). '">';

							}

						}

						print '<h1 class="userinfo">' .$username. '</h1>';

					?>

					<span class="error"><?= $error; ?></span>

				</div>

				<div class="inputfield">
					
					<p class="following">Following:<br>

					<?php 	

						if ($following) {

							foreach ($following as $value) {
							
							print '<a href="viewuser.php?username=' .$value["userpath"]. '">' .$value["username"]). ' <img class="searchpic" src="' .$value["picpath"]. '"></a><br>';
							
							}

						} else {

							print '<p class="nofollowers">You\'re not following anyone, search for fellaz</p><br>';

						}

					?>

					</p>

					<p class="following">Followers:<br>
					
					<?php

						if ($followers) {

							foreach ($followers as $value) {
							
								print '<a href="viewuser.php?username=' .$value["userpath"]. '">' .$value["username"]. ' <img class="searchpic" src="' .$value["picpath"]. '"></a><br>';
							} 

						} else {

							print '<p class="nofollowers">No followers</p>';

						}

					 ?>

					</p>

				</div>		

			</div>

		</div>

	</body>

</html>