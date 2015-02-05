<?php

	require_once("secret.php");

	$error = "";

	function connectToDB () {

		$connection = mysqli_connect(DBSERVER, DBUSER, DBPASS, DB);

		if (!$connection) {
				
			print "Failed to connect to MySQL: " . mysqli_connect_error();

		} else {

			return $connection;

		}

	}

	function validateEmail ($email) {

		$validEmail = filter_var($email, FILTER_VALIDATE_EMAIL);

		if (!$validEmail) {

			return false;

		} else {

			return true;

		}

	}

	function createUser ($username, $password, $email, $userpath) {

		$db = connectToDB();

		$username = mysqli_real_escape_string($db, $username);
		$password = mysqli_real_escape_string($db, $password);
		$email    = mysqli_real_escape_string($db, $email);
		$userpath = mysqli_real_escape_string($db, $userpath);

		$query = "INSERT INTO `users` (`username`, `pwd`, `email`, `userpath`) VALUES ('$username', '$password', '$email', '$userpath')";

		$result = mysqli_query($db, $query);

		if (!$result) {

			error_log("ERROR" . mysql_error($db));
			mysqli_close($db);
			exit;

		}

		mysqli_close($db);

	}
		

	function checkUsername ($username) {

		$db = connectToDB();

		$query = "SELECT id, username FROM `users` WHERE `username` = '$username'";

		$result = mysqli_query($db, $query);

		if (!$result) {

	    	error_log("Felaktig query!" . mysqli_error($db));
	    	mysqli_close($db);
	    	exit;

	    } else {

			$row = mysqli_fetch_assoc($result);
			mysqli_close($db);
			return $row;

		}

	}

	function getUser ($username, $password) {

		$db = connectToDB();

		$query = "SELECT id, username FROM `users` WHERE `username` = '$username' AND `pwd` = '$password'";

		$result = mysqli_query($db, $query);

		if (!$result) {

	    	error_log("Invalid query!" . mysqli_error($db));
	    	mysqli_close($db);
	    	exit;

	    } else {

			$row = mysqli_fetch_assoc($result);
			mysqli_close($db);
			return $row;

		}

	}

	function viewProfile ($userinfo) {

		$db = connectToDB();

		$result = mysqli_query($db, "SELECT * FROM users WHERE userpath = '$userinfo'");

		if (!$result) {
	    	error_log("Invalid query!" . mysqli_error($db));
	    	mysqli_close($db);
	    	exit;
	    }

	    $array = array();

		while($row = mysqli_fetch_assoc($result)){

			$array[] = $row;

		}

		mysqli_close($db);

		return $array;

	}

	function createPost ($message, $userid, $username) {

		$db = connectToDB();

		$message = mysqli_real_escape_string($db, $message);
		$userid  = mysqli_real_escape_string($db, $userid);

		$date = date("Y-m-d");

		$query = "INSERT INTO guestbook (message, userid, dateofpost, username) VALUES ('$message', '$userid', '$date', '$username')";

		$result = mysqli_query($db, $query);

		if (!$result) {

			error_log("Invalid query!" . mysql_error($db));
			mysqli_close($db);
			exit;

		}

		mysqli_close($db);

	}

	function getPosts ($userid) {

		$db = connectToDB();

		$result = mysqli_query($db, "SELECT message, dateofpost, id, username, picpath FROM guestbook WHERE userid = '$userid' AND replyid IS NULL ORDER BY id DESC");

		if (!$result) {
	    	error_log("Invalid query!" . mysqli_error($db));
	    	mysqli_close($db);
	    	exit;
	    }

	    $array = array();

		while($row = mysqli_fetch_assoc($result)){

			$array[] = $row;

		}

		mysqli_close($db);

		return $array;

	}

	function createComment ($comment, $userid, $username, $replyid) {

		$db = connectToDB();

		$comment = mysqli_real_escape_string($db, $comment);
		$userid  = mysqli_real_escape_string($db, $userid);

		$date = date("Y-m-d");

		$query = "INSERT INTO guestbook (message, userid, username, dateofpost, replyid) VALUES ('$comment', '$userid', '$username', '$date', '$replyid')";

		$result = mysqli_query($db, $query);

		if (!$result) {

			error_log("Invalid query!" . mysql_error($db));
			mysqli_close($db);
			exit;

		}

		mysqli_close($db);

	}

	function getComments ($id) {

		$db = connectToDB();

		$result = mysqli_query($db, "SELECT message, dateofpost, id, replyid, username FROM guestbook WHERE replyid = '$id'");

		if (!$result) {
	    	error_log("Invalid query!" . mysqli_error($db));
	    	mysqli_close($db);
	    	exit;
	    }

	    $array = array();

		while($row = mysqli_fetch_assoc($result)){

			$array[] = $row;

		}

		mysqli_close($db);

		return $array;

	}

	function searchForUser ($username) {

		$db = connectToDB();

		$username = mysqli_real_escape_string($db, $username);

		$query = "SELECT username, userpath, picpath FROM users WHERE username LIKE '%$username%'";

		$result = mysqli_query($db, $query);

		if (!$result) {

			error_log("Invalid query!" . mysql_error($db));
			mysqli_close($db);
			exit;

		}

		$array = array();

		while($row = mysqli_fetch_assoc($result)){

			$array[] = $row;

		}

		mysqli_close($db);

		return $array;

	}

	function createPicPath ($path, $userid) {

		$db = connectToDB();

		$path   = mysqli_real_escape_string($db, $path);
		$userid = mysqli_real_escape_string($db, $userid);

		$query = "UPDATE users SET picpath = '$path' WHERE id = '$userid'";

		$result = mysqli_query($db, $query);

		if (!$result) {

			error_log("Invalid query!" . mysql_error($db));
			mysqli_close($db);
			exit;

		}

		mysqli_close($db);

	}

	function getPicPath ($userid){

		$db = connectToDB();

		$result = mysqli_query($db, "SELECT picpath FROM users WHERE id = '$userid'");

		if (!$result) {
	    	error_log("Invalid query!" . mysqli_error($db));
	    	mysqli_close($db);
	    	exit;
	    }

		$array = array();

		while($row = mysqli_fetch_assoc($result)){

			$array[] = $row;

		}

		mysqli_close($db);

		return $array;

	}

	function createPostWithPic ($message, $userid, $username, $picpath) {

		$db = connectToDB();

		$message = mysqli_real_escape_string($db, $message);
		$userid  = mysqli_real_escape_string($db, $userid);
		$username = mysqli_real_escape_string($db, $username);
		$picpath = mysqli_real_escape_string($db, $picpath);

		$date = date("Y-m-d");

		$query = "INSERT INTO guestbook (message, userid, dateofpost, username, picpath) VALUES ('$message', '$userid', '$date', '$username', '$picpath')";

		$result = mysqli_query($db, $query);

		if (!$result) {

			error_log("Invalid query!" . mysql_error($db));
			mysqli_close($db);
			exit;

		}

		mysqli_close($db);

	}

	function followUser ($userid, $followid) {

		$db = connectToDB();

		$userid = mysqli_real_escape_string($db, $userid);
		$followid  = mysqli_real_escape_string($db, $followid);

		$query = "INSERT INTO following (userid, followid) VALUES ('$userid', '$followid')";

		$result = mysqli_query($db, $query);

		if (!$result) {

			error_log("Invalid query!" . mysql_error($db));
			mysqli_close($db);
			exit;

		}

		mysqli_close($db);

	}

	function checkFollower ($userid, $followid) {

		$db = connectToDB();

		$query = "SELECT userid, followid FROM `following` WHERE `userid` = '$userid' AND `followid` = '$followid'";

		$result = mysqli_query($db, $query);

		if (!$result) {

	    	error_log("Invalid query!" . mysqli_error($db));
	    	mysqli_close($db);
	    	exit;

	    } else {

			$row = mysqli_fetch_assoc($result);
			mysqli_close($db);
			return (bool)$row; //Bool för att den ska ange true eller false

		}

	}

	function unFollowUser ($userid, $followid) {

		$db = connectToDB();

		$query = "DELETE FROM following WHERE `userid` = '$userid' AND `followid` = '$followid'";

		mysqli_query($db, $query);

		mysqli_close($db);

	}

	function followingUsers ($userid) {

		$db = connectToDB();
			
		$result = mysqli_query($db, "SELECT username, userpath, picpath FROM users WHERE id IN ( SELECT followid FROM following WHERE userid = '$userid' )");

		// Gör en funktion!
		// function workordie($db) {
		// 	if mysqli_errno($db) > 0)


		// }

		if (!$result) {
	    	error_log("Invalid query!" . mysqli_error($db));
	    	mysqli_close($db);
	    	exit;
	    }

	    $following = array();

		while($row = mysqli_fetch_assoc($result)){

			$following[] = $row;

		}
		
		mysqli_close($db);

		return $following;

	}

	function getFollowers ($userid) {

		$db = connectToDB();

		$result = mysqli_query($db, "SELECT username, userpath, picpath FROM users WHERE id IN ( SELECT userid FROM following WHERE followid = '$userid')");

		if (!$result) {
	    	error_log("Invalid query!" . mysqli_error($db));
	    	mysqli_close($db);
	    	exit;
	    }

		$followers = array();

		while($row = mysqli_fetch_assoc($result)){

		$followers[] = $row;

		}

		mysqli_close($db);

		return $followers;
	}

	function Sanitize ($string) {

		return filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS);

	}

	function createSession ($user) {

		$_SESSION["userdata"] = $user;

		#setcookie("userdata", $user["username"], time() + (60*60*24));

	}

	function find_hashtags($tweet) {
	
		return preg_replace("/(#(\w+))/", '<a href="searchresult.php?search=%23$2">$1</a>' , $tweet);

	}	

	function getHashtags($hashtag) {
		$db = connectToDB();
		$result = mysqli_query($db, "SELECT * FROM guestbook WHERE message LIKE '%$hashtag%'");

		if (!$result) {
	    	error_log("Invalid query!" . mysqli_error($db));
	    	mysqli_close($db);
	    	exit;
	    }

	    $array = array();

		while($row = mysqli_fetch_assoc($result)){

			$array[] = $row;

		}

		mysqli_close($db);

		return $array;

	}

	function find_at_tag_profile($username) {

		return preg_replace('/(?<=^|\s)@([a-z0-9_]+)/i', '<a href="profile.php">@$1</a>', $username);


	}

	function find_at_tag_viewuser ($username, $userpath) {

		return preg_replace('/(?<=^|\s)@([a-z0-9_]+)/i', '<a href="viewuser.php?username=' .$userpath. '">@$1</a>', $username);

	}

	function getUserpath ($username){

		$db = connectToDB();

		$query = "SELECT userpath FROM users WHERE username LIKE '%$username%'";

		$result = mysqli_query($db, $query);

		if (!$result) {
	    	error_log("Invalid query!" . mysqli_error($db));
	    	mysqli_close($db);
	    	exit;
	    }

	    $array = array();

		while($row = mysqli_fetch_assoc($result)){

			$array[] = $row;

		}

		mysqli_close($db);

		return $array;

	}












