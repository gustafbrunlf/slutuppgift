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

	$guestbook = getPosts($userid);
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

			</header>

			<div class="inputwrapper">

				<div class="searchresult">
					
					<h1 class="userinfo">Search result for: <?= $search; ?></h1>
					<p>

					<?php 

						if ($userresult) {

							foreach ($userresult as $value) {

								print '<a href="viewuser.php?username=' .Sanitize($value["userpath"]). '">' .Sanitize($value["username"]). ' <img class="searchpic" src="' .Sanitize($value["picpath"]). '"></a><br>';

							}

						}

						if ($hashtagresult) {

							foreach ($hashtagresult as $value) {

								$message = Sanitize($value["message"]);
								$searchusername = Sanitize($value["username"]);
								$usernameat = ltrim ($searchusername, '@');
								$userpath = getUserpath($usernameat);

								if ($username == $usernameat) {

									print find_at_tag_profile($searchusername). "<br>" .$message. "<br>";

								} else {

									foreach ($userpath as $path) {
														
										print find_at_tag_viewuser($searchusername, $path["userpath"]). "<br>" .$message. "<br>";
 
									}

								}

							}

						}

						print $searcherror;

					?> 

					</p>

				</div>	

			</div>

		</div>

	</body>

</html>