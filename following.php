<?php 

	require_once("server/functions.php");

	$session = checkSession();

	if (!$session) {
		$_SESSION["error"] = "You need to log in";
		header("Location: login.php");
		die;

	}

	$userid   = $_SESSION["userdata"]["id"];
	$username = $_SESSION["userdata"]["username"];

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

					<input type="text" name="search" id="searchinput" placeholder="Search for a # or a username">
					<button type="submit" id="searchbutton">search</button>

				</form>

			</header>

			<section>

				<div class="followbox">

					<div class="profile profilefollow">

						<?php foreach ($getpic as $value): ?>

						<img class="profilepic" src="img/profile/<?php if ($value["picpath"]) { print $value["picpath"]; } else { print "standard.png"; } ?>">

						<?php endforeach ?>

						<h1 class="userinfo"><?= $username ?></h1> 

						<div class="following user">
					
							<p>You're following:<br>

							<?php if ($following) : 

								foreach ($following as $value) : ?>
									
								<a href="viewuser.php?username=<?= $value["userpath"]; ?>"><?= $value["username"]?><img class="searchpic" src="img/profile/<?php if ($value["picpath"]) { print $value["picpath"]; } else { print "standard.png"; } ?>"></a><br>	
									
							<?php endforeach; else : ?>

								<p class="nofollowers"><?= "No-one"; ?></p><br>

							<?php endif; ?>

							</p>

						</div>

						<div class="following user">

							<p>Your followers:<br>
							
							<?php if ($followers) :

								foreach ($followers as $value) : ?>
									
								<a href="viewuser.php?username=<?= $value["userpath"]; ?>"><?= $value["username"]; ?><img class="searchpic" src="img/profile/<?php if ($value["picpath"]) { print $value["picpath"]; } else { print "standard.png"; } ?>"></a><br>
							
							<?php endforeach; else : ?>

								<p class="nofollowers"><?= "No followers"; ?></p>

							<?php endif; ?>

							</p>

						</div>

						<span class="error"><?= $error; ?></span>

					</div>
				
				</div>

			</section>

		</div>

	</body>

</html>