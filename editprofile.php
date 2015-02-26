<?php 

	require_once("server/functions.php");
	require_once("server/searchfield.php");

	$session = checkSession();

	if (!$session) {

		$_SESSION["error"] = "You need to log in";
		header("Location: index.php");
		die;

	}

	require_once("server/uploadpic.php");

	$userid   = $_SESSION["userdata"]["id"];
	$username = $_SESSION["userdata"]["username"];
	
	$getpic    = getPicPath($userid);
	$following = followingUsers($userid);
	$userinfo  = getUserInfo($userid);

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
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/mobile.css">
  </head>
 	
	<body>

		<div id="container">
			
			<header>
				
				<nav>
					<ul id="menu">
						<li class="logout"><a href="logout.php">Log out</a></li>
						<li class="update"><a href="profile.php">Home</a></li>
					</ul>
				</nav>
				
				<h1><a href="profile.php">What's cooking?</a></h1>

				<form class="search" action="searchresult.php?search=" method="GET">

					<input type="text" name="search" id="searchinput" placeholder="Find a # or a username">
					<button type="submit" id="searchbutton">search</button>

				</form>

				<?= $search; ?>

			</header>

			<section>

				<div class="editprofile">

					<?php foreach ($getpic as $value) : ?>

					<img class="profilepic" src="img/profile/<?php if ($value["picpath"]) { print $value["picpath"]; } else { print "standard.png"; } ?>">

					<?php endforeach ?>

					<h1 class="userinfo"><?= $username; ?></h1>

					<form enctype="multipart/form-data" action="" method="POST">

						<input class="inputupload" type="file" name="upload">
						<h2 class="about">About: </h2>
						<textarea name="message" id="uploadtext" maxlength="200"><?php if(isset($userinfo)){ foreach ($userinfo as $value) { echo $value["userinfo"]; } }?></textarea>
						<button id="uploadbutton" type="submit">Sav<span>e</span></button>

					</form>

					<span class="error"><?= $error; ?></span>

				</div>	

			</section>	

		</div>

	</body>

</html>