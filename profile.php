<?php 

	session_start();

	if (!isset($_SESSION["userdata"])) {

		$_SESSION["error"] = "You're not logged in";
		header("Location: login.php");
		die;

	}

	require_once("functions.php");
	require_once("savepost.php");
	require_once("searchfield.php");
	#require_once("savecomment.php");

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
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/script.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>

  </head>
 	
	<body>

		<div id="container">
			
			<header>
				
				<h3 class="logout"><a href="logout.php">Log out</a></h3>
				<h3 class="update"><a href="editprofile.php">Edit profile</a></h3>
				
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

							foreach ($getpic as $value) {

								if(!$value["picpath"]){

									print '<img class="profilepic" src="profile/standard.jpg">';

								} else {

									print '<img class="profilepic" src="' .Sanitize($value["picpath"]). '">';

								}

							}

							print '<h1 class="userinfo">' .$username. '</h1>'; 

						?>
						
						<table class="userstatistics">
							<tr>
								<th>Messages:</th>
								<th>Following:</th>
								<th>Followers:</th>
							</tr>
							<tr>
								<td><?= count($guestbook); ?></td>
								<td><a href="following.php"><?= count($following); ?></a></td>
								<td><a href="following.php"><?= count($followers); ?></a></td>
							</tr>
						</table>

					</div>

					<span class="error"><?= $error; ?></span>

				</div>

				<div class="inputfield">
					
					<div class="postform">
						<form enctype="multipart/form-data" action="profile.php" method="POST">

							<textarea name="message" id="textarea" class="inputarea" oninput="counter()"></textarea><br>
							<div id="count">200</div>
							<input class="inputupload" type="file" name="upload">
							<button type="submit" class="inputbutton">post somethin'</button>

						</form>
					</div>
					
					<div class="result">
						<?php 

							if ($guestbook) {
								
								foreach ($guestbook as $value) {

									$post = Sanitize($value["message"]);
									$username = Sanitize($value["username"]);
								
									print	'<div id="toggle">';	
									print 	'<div class="postinfo">' .find_at_tag_profile($username). ' ' .Sanitize($value["dateofpost"]). '</div>'; 
									print 	'<div class="usermessage">' .find_hashtags($post). '</div>';
									if($value["picpath"]){
									print   '<div class="postpic"><img src="' .$value["picpath"]. '"></div>';
									}
									print	'</div>'; 
									print 	'<form action="profile.php" method="POST">';
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
											$username = Sanitize($value["username"]);
											$userpath = ltrim ($username, '@');
											$userpath = getUserpath($userpath);

											print 	'<div class="commentinfo">';

											foreach ($userpath as $path) {
													
												print find_at_tag_viewuser($username, $path["userpath"]);

											}

											print 	" " .Sanitize($value["dateofpost"]). '</div>';
											print 	'<div class="comment">' .find_hashtags($post). '</div>';

										}

									}

									print "<hr>";
									print "</div>";

								}

							} else {

								print '<h1 class="emptyresult">Write your first post here!</h1>';

							}

						?>

					</div>

				</div>

		</div>

	</body>

</html>