<?php 

	session_start();

	if (!isset($_SESSION["userdata"])) {

		$_SESSION["error"] = "You need to log in";
		header("Location: login.php");
		die;

	}
	
	require_once("server/data.php");
	require_once("server/searchfield.php");

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

						if ($userresult) :

							foreach ($userresult as $value) : ?>

							<a href="viewuser.php?username=<?= $value["userpath"]; ?>"><?= $value["username"]; ?><img class="searchpic" src="img/profile/
								<?php if ($value["picpath"]) { print $value["picpath"]; } else { print "standard.jpg"; } ?>"></a><br>

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

			</div>

		</div>

	</body>

</html>