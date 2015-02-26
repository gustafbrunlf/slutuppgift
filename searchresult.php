<?php 

	require_once("server/functions.php");
	require_once("server/searchfield.php");

	$session = checkSession();

	if (!$session) {

		$_SESSION["error"] = "You need to log in";
		header("Location: index.php");
		die;

	}

	if (isset($_SESSION["error"])) {

		$error = $_SESSION["error"];
		unset($_SESSION["error"]);

	}

	$userid   = $_SESSION["userdata"]["id"];
	$username = $_SESSION["userdata"]["username"];
	
	$getpic    = getPicPath($userid);
	$following = followingUsers($userid);
	$followers = getFollowers($userid);

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

			</header>

			<section>

				<div class="searchresult">
					
					<h1>Search result for: <?= $search; ?></h1>

					<?php 

						if ($userresult) :

							foreach ($userresult as $value) : ?>

							<a href="userprofile.php?username=<?= $value["userpath"]; ?>"><?= $value["username"]; ?><img class="searchpic" src="img/profile/
								<?php if ($value["picpath"]) { print $value["picpath"]; } else { print "standard.png"; } ?>"></a><br>

					<?php 	

							endforeach;

						endif; 

						if ($hashtagresult) :

							foreach ($hashtagresult as $value) :

								$message = $value["message"];
								$searchusername = $value["username"]; ?>

									<p><?= get_profile_link($searchusername); ?><br> <?= $message; ?><br>

								<?php 

							endforeach;

						endif; ?>

						<p><?= $searcherror; ?></p>

				</div>	

			<section>

		</div>

	</body>

</html>