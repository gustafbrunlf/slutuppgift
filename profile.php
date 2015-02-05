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
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!--<script src="js/script.js"></script>-->
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>

  </head>
 	
	<body>

		<div class="container">
			
			<div class="row">
				<header class="col-md-12">
					
					<div class="col-md-4">	
						<div class="col-md-6">
							<h5 class="logout"><a href="logout.php">Log out</a></h5>
						</div>
						<div class="col-md-6">
							<h5 class="update"><a href="editprofile.php">Edit profile</a></h5>
						</div>
					</div>
					<div class="col-md-6">
						<h1><a href="profile.php">What's cooking?</a></h1>
					</div>
					<div class="col-md-2 tja">
						<form class="search" action="searchresult.php?search=" method="GET">

							<input type="text" name="search" id="searchinput">
							<button type="submit" id="searchbutton">search</button>

						</form>
					</div>

				</header>
			</div>
	
			<div class="row">
				
				<div class="col-md-12">

					<div class="col-md-6">
						
						<div class="col-md-12">
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

						</div>
						
						<table class="col-md-6">
							<tr>
								<th class="col-md-4">Messages:</th>
								<th class="col-md-4">Following:</th>
								<th class="col-md-4">Followers:</th>
							</tr>
							<tr>
								<td class="col-md-4"><?= count($guestbook); ?></td>
								<td class="col-md-4"><a href="following.php"><?= count($following); ?></a></td>
								<td class="col-md-4"><a href="following.php"><?= count($followers); ?></a></td>
							</tr>
						</table>

					</div>

					<span class="error"><?= $error; ?></span>

				<div class="col-md-6">
					
					<div class="postform">
						<form enctype="multipart/form-data" action="profile.php" method="POST">

							<textarea type="text" name="message" class="inputarea"></textarea><br>
							<input class="inputupload" type="file" name="upload">
							<button type="submit" class="inputbutton">post somethin'</button>

						</form>
					</div>
					
					<div class="result">
						<?php 

							if ($guestbook) {
								
								foreach ($guestbook as $value) {

									$post = Sanitize($value["message"]);
								
									print	'<div id="toggle">';	
									print 	'<div class="postinfo">' .Sanitize($value["username"]). ' ' .Sanitize($value["dateofpost"]). '</div>'; 
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
													
												print find_at_tag_user($username, $path["userpath"]);

											}

											print " " .Sanitize($value["dateofpost"]). '</div>';
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

		</div>

	</body>

</html>