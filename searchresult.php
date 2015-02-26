<?php 

	require_once("server/functions.php");

	$session = checkSession();

	if (!$session) {
		$_SESSION["error"] = "You need to log in";
		header("Location: login.php");
		die;

	}
	
	require_once("server/searchfield.php");

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

					<input type="text" name="search" id="searchinput" placeholder="Find a # or a username">
					<button type="submit" id="searchbutton">search</button>

				</form>

			</header>

			<section>

				<div class="searchresult">
					
					<h1>Search result for: <?= $search; ?></h1>
					<p>

					<?php 

						if ($userresult) :

							foreach ($userresult as $value) : ?>

							<a href="viewuser.php?username=<?= $value["userpath"]; ?>"><?= $value["username"]; ?><img class="searchpic" src="img/profile/
								<?php if ($value["picpath"]) { print $value["picpath"]; } else { print "standard.png"; } ?>"></a><br>

					<?php 	

							endforeach;

						endif; 

						if ($hashtagresult) :

							foreach ($hashtagresult as $value) :

								$message = $value["message"];
								$searchusername = $value["username"];
								$usernameat = ltrim ($searchusername, '@');
								$userpath = getUserpath($usernameat);

								if ($username == $usernameat) : ?>

									<p> <?= find_at_tag_profile($searchusername); ?><br> <?= $message; ?><br>

								<?php 

								else :

									foreach ($userpath as $path) : ?>
														
										<p><?= find_at_tag_viewuser($searchusername, $path["userpath"]); ?><br><?= $message; ?><br>
 
								<?php	endforeach;

								endif;

							endforeach;

						endif; ?>

						<?= $searcherror; ?>

					</p>

				</div>	

			<section>

		</div>

	</body>

</html>