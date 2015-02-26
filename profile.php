<?php

	require_once("server/functions.php");

	$session = checkSession();

	if (!$session) {
		$_SESSION["error"] = "You need to log in";
		header("Location: login.php");
		die;

	}

	require_once("server/searchfield.php"); 
	require_once("server/savepost.php");

	$userid   = $_SESSION["userdata"]["id"];
	$username = $_SESSION["userdata"]["username"];

	$guestbook = getPostsProfile($userid);
	$getpic    = getPicPath($userid); 
	$following = followingUsers($userid);
	$followers = getFollowers($userid);
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
						<li><a href="logout.php">Log out</a></li>
						<li><a href="editprofile.php">Edit <span>profile</span></a></li>
					</ul>
				</nav>
				
				<h1><a href="profile.php">What's cooking?</a></h1>

				<form class="search" action="searchresult.php?search=" method="GET">

					<input type="text" name="search" id="searchinput" placeholder="Find a # or a username">
					<button type="submit" id="searchbutton">search</button>

				</form>

			</header>

			<section>

				<div class="center">
			
					<div class="profilebox">

						<div class="profile">

							<?php foreach ($getpic as $value): ?>

							<img class="profilepic" src="img/profile/<?php if ($value["picpath"]) { print $value["picpath"]; } else { print "standard.jpg"; } ?>">

							<?php endforeach ?>

							<h1 class="userinfo"><?= $username ?></h1> 

							<div class="about">
								<h2>About: </h2>
								<p><?php if(isset($userinfo)){ foreach ($userinfo as $value) { if($value["userinfo"]) { print $value["userinfo"]; } else { print "No info"; } } } ?></p>
							</div>
							
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
								<input type="hidden" name="action" value="post">
								<textarea name="message" class="inputarea" maxlength="200" placeholder="What's cooking today?"></textarea><br>
								<div id="count">200</div>
								<input class="inputupload" type="file" name="upload">
								<button type="submit" class="inputbutton">post something<span>!</span></button>

							</form>
						</div>
						
						<div class="result">
							
							<?php 

								if ($guestbook) {
									
									foreach ($guestbook as $value) {
										$post = $value["message"];
										$username = $value["username"];
										print  '<div class="wrapper">
												<div id="toggle">	
												<div class="postinfo"><span>' .find_at_tag_profile($username). '</span> ' .$value["dateofpost"]. '</div> 
												<div class="usermessage">' .convertUrl(find_hashtags($post)). '</div>';
												if($value["picpath"]){
										print   '<div class="postpic"><img src="img/post/' .$value["picpath"]. '"></div>';
												}
										print	'</div>
												<div class="toggle">
												<div class="commentfield">
												<form action="" method="POST">
												<input type="hidden" name="action" value="comment">
												<input type="text" name="comment" class="commentinput">
												<input type="hidden" name="id" value="' .$value["id"]. '">
												<button type="submit" class="commentbutton">Repl<span>y</span></button>
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
														
													print '<span>' .find_at_tag_viewuser($username, $path["userpath"]). "</span> " .$value["dateofpost"];
												}
												print 	'</div>
														<div class="comment">' .convertUrl(find_hashtags($post)). '</div>';
											}
										}

											print "</div>";
										print "</div>";

									}

								} else {

									print '<h1 class="emptyresult">Write your first post!</h1>';

								}

							?>

						</div>

					</div>

				</div>

			</section>

		</div>

	<script src="js/jquery.min.js"></script>
   	<script src="js/script.js"></script>

	</body>

</html>