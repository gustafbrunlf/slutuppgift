<?php 
	
	session_start();

	if (!isset($_SESSION["userdata"])) {

		$_SESSION["error"] = "You need to log in";
		header("Location: login.php");
		die;

	}

	require_once("server/data.php");
	require_once("server/searchfield.php");

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
  </head>
 	
	<body>

		<div id="container">
			
			<header>
				
				<h3 class="logout"><a href="logout.php">Log out</a></h3>
				<h3 class="update"><a href="profile.php">Home</a></h3>
				
				<h1><a href="profile.php">What's cooking?</a></h1>

				<form class="search" action="searchresult.php?search=" method="GET">

					<input type="text" name="search" id="searchinput" placeholder="Search for a # or a username">
					<button type="submit" id="searchbutton">search</button>

				</form>

				<?= $search; ?>

			</header>

			<div class="inputwrapper">

				<div class="profilebox">

					<div class="profile profilefollow">

					<?php foreach ($getpic as $value): ?>

					<img class="profilepic" src="img/profile/<?php if ($value["picpath"]) { print $value["picpath"]; } else { print "standard.jpg"; } ?>">

					<?php endforeach; $userinfo = array_pop($data); ?>

					<h1 class="userinfo"><?= $userinfo["username"]; ?></h1> 

					<span class="error"><?= $error; ?></span>

					</div>

				</div>

				<div class="inputfield">
					
					<p class="following">Following:<br>

					<?php if ($following) : 

						foreach ($following as $value) : ?>
							
						<a href="viewuser.php?username=<?= $value["userpath"]; ?>"><?= $value["username"]?><img class="searchpic" src="img/profile/<?php if ($value["picpath"]) { print $value["picpath"]; } else { print "standard.jpg"; } ?>"></a><br>	
							
					<?php endforeach; else : ?>

						<p class="nofollowers"><?= "You\'re not following anyone, search for fellaz"; ?></p><br>

					<?php endif; ?>

					</p>

					<p class="following">Followers:<br>

					 <?php if ($followers) :

						foreach ($followers as $value) : ?>
							
						<a href="viewuser.php?username=<?= $value["userpath"]; ?>"><?= $value["username"]; ?><img class="searchpic" src="img/profile/<?php if ($value["picpath"]) { print $value["picpath"]; } else { print "standard.jpg"; } ?>"></a><br>
					
					<?php endforeach; else : ?>

						<p class="nofollowers"><?= "No followers"; ?></p>

					<?php endif; ?>

					</p>

				</div>		

			</div>

		</div>

	</body>

</html>