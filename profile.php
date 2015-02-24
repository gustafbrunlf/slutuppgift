<?php 

	session_start();

	if (!isset($_SESSION["userdata"])) {

		$_SESSION["error"] = "You need to log in";
		header("Location: login.php");
		die;

	}

	require_once("server/data.php");
	require_once("server/savepost.php");
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

						<?php foreach ($getpic as $value): ?>

						<img class="profilepic" src="img/profile/<?php if ($value["picpath"]) { print $value["picpath"]; } else { print "standard.jpg"; } ?>">

						<?php endforeach ?>

						<h1 class="userinfo"><?= $username ?></h1> 
						
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
						<form enctype="multipart/form-data" action="" method="POST">

							<textarea name="message" id="textarea" class="inputarea" maxlength="200"></textarea><br>
							<div id="count">200</div>
							<input class="inputupload" type="file" name="upload">
							<button type="submit" class="inputbutton">post somethin'</button>

						</form>
					</div>
					
					<div class="result">
						
						<?php 

							if ($guestbook) {
								
								foreach ($guestbook as $value) {
									$post = $value["message"];
									$username = $value["username"];
								
									print	'<div id="toggle">	
											<div class="postinfo">' .find_at_tag_profile($username). ' ' .$value["dateofpost"]. '</div> 
											<div class="usermessage">' .find_hashtags($post). '</div>';
											if($value["picpath"]){
									print   '<div class="postpic"><img src="img/post/' .$value["picpath"]. '"></div>';
											}
									print	'</div>
											<div class="toggle">
											<div class="commentfield">
											<form action="" method="POST">
											<input type="text" name="comment" class="commentinput">
											<input type="hidden" name="id" value="' .$value["id"]. '">
											<button type="submit" class="commentbutton">comment</button>
											</form></div>';

									$getcomments = getComments($value["id"]);
									if ($getcomments) {
										foreach ($getcomments as $value) {
											
											$post = $value["message"];
											$username = $value["username"];
											$userpath = ltrim ($username, '@');
											$userpath = getUserpath($userpath);
											print 	'<div class="commentinfo">';
											foreach ($userpath as $path) {
													
												print find_at_tag_viewuser($username, $path["userpath"]). " " .$value["dateofpost"];
											}
											print 	'</div>
													<div class="comment">' .find_hashtags($post). '</div>';
										}
									}
									print "<hr>";
									print "</div>";
								}

							} else {

								print '<h1 class="emptyresult">Write your first post!</h1>';

							}

						?>

					</div>

				</div>

		</div>

	</body>

</html>