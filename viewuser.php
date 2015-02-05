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
		
		$guestbookpost = getPosts($value["id"]);
		$picpath       = getPicPath($value["id"]);
		$following     = followingUsers($value["id"]);
		$followers     = getFollowers($value["id"]);

	}

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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/script.js"></script>
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

				<div class="profilebox">

					<div class="profile">

						<?php 

							foreach ($picpath as $value) {

								if ($value['picpath']) {

									print '<img class="profilepic" src="' .Sanitize($value["picpath"]). '">';

								} else {

									print '<img class="profilepic" src="profile/standard.jpg">';

								}
							}
							
							$userinfo = array_pop($data); //Kolla upp denna!
							print '<h1 class="userinfo">' .$userinfo["username"]. '</h1>';

						?>

						<table class="userstatistics">
							<tr>
								<th>Messages:</th>
								<th>Following:</th>
								<th>Followers:</th>
							</tr>
							<tr>
								<td><?= count($guestbookpost); ?></td>
								<td><a href="viewuserfollowing.php?username=<?= $userinfo["userpath"]; ?>"><?= count($following); ?></a></td>
								<td><a href="viewuserfollowing.php?username=<?= $userinfo["userpath"]; ?>"><?= count($followers); ?></a></td>
							</tr>
						</table>
						
						<form method="POST" action="savefollow.php">
							<input type="hidden" name="userid" value="<?= $userinfo["id"]; ?>">
							<button class="followbutton"><?php if (checkFollower($_SESSION['userdata']['id'], $userinfo["id"])) { print 'Unfollow'; } else { print 'Follow'; } ?></button>

						</form>

						</div>

						<span class="error"><?= $error; ?></span>

					</div>
					
					<div class="viewuserpost">
						
						<div class="viewresults">
							
							<?php

								if ($guestbookpost) {
									
									foreach ($guestbookpost as $value) {

										$post = Sanitize($value["message"]);
										
										print	'<div id="toggle">';
										print 	'<div class="postinfo">' .Sanitize($value["username"]). " " .Sanitize($value["dateofpost"]). '</div>'; 
										print 	'<div class="usermessage">' .find_hashtags($post). '</div>';
										if($value["picpath"]){
										print   '<div class="postpic"><img src="' .$value["picpath"]. '"></div>';
										}
										print	'</div>'; 
										print 	'<form action="savecommentview.php" method="POST">';
										print	'<div class="toggle">';
										print   '<div class="commentfield">
												<input type="text" name="comment" class="commentinput">
												<input type="hidden" name="id" value="' .$value["id"]. '">
												<button type="submit" class="commentbutton">comment</button>

												</form></div>';

										$getcomments = getComments($value["id"]);

										if ($getcomments) {

											foreach ($getcomments as $value) {

												$post = Sanitize($value["message"]);
												
												print 	'<div class="commentinfo">' .Sanitize($value["username"]). " " .Sanitize($value["dateofpost"]). '</div>';
												print 	'<div class="comment">' .find_hashtags($post). '</div>';

											}

										}

										print "<hr>";
										print "</div>";

									}

								} else {

									print '<h1 class="emptyresult">' .$userinfo["username"]. ' hasn\'t written any posts so far!</h1>';

								}

							?>

						</div>

					</div>

				</div>

				<div>

					<span style="color: red;"><?= $error; ?></span>
			
				</div>

			</div>

		</div>

	</body>

</html>