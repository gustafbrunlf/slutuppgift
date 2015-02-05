<?php 
	
	session_start();

	if (!isset($_SESSION["userdata"])) {

		$_SESSION["error"] = "You're not logged in";
		header("Location: login.php");
		die;

	}

	require_once("functions.php");
	require_once("searchfield.php");

	$userinfo = $_GET["username"];

	$data = viewProfile($userinfo);

	foreach ($data as $value) {
		
		$getpic        = getPicPath($value["id"]);
		$following     = followingUsers($value["id"]);
		$followers     = getFollowers($value["id"]);

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

						$userinfo = array_pop($data); //Kolla upp denna!
						print '<h1 class="userinfo">User: ' .$userinfo["username"]. '</h1>';

					?>

					<span class="error"><?= $error; ?></span>

				</div>

				<div class="inputfield">
					
					<p class="following">Following:<br>

					<?php 	

						if ($following) {

							foreach ($following as $value) {
							
							print '<a href="viewuser.php?username=' .Sanitize($value["userpath"]). '">' .Sanitize($value["username"]). ' <img class="searchpic" src="' .Sanitize($value["picpath"]). '"></a><br>';
							
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
							
								print '<a href="viewuser.php?username=' .Sanitize($value["userpath"]). '">' .Sanitize($value["username"]). ' <img class="searchpic" src="' .Sanitize($value["picpath"]). '"></a><br>';
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