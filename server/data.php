<?php

	require_once("database.php");

	$error = "";

	function createSession ($user) {

		$_SESSION["userdata"] = $user;

		#setcookie("userdata", $user["username"], time() + (60*60*24));

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

		$query = "INSERT INTO `users` (`username`, `pwd`, `email`, `userpath`) VALUES ('$username', '$password', '$email', '$userpath')";

		insertDBContent($query);

	}

	function checkUsername ($username) {

		$query = "SELECT id, username FROM `users` WHERE `username` = '$username'";

		$result = getDBContentRow($query);

		return $result;

	}

	function getUser ($username, $password) {

		$query = "SELECT id, username FROM `users` WHERE `username` = '$username' AND `pwd` = '$password'";

		$result = getDBContentRow($query);

		return $result;

	}

	function viewProfile ($userinfo) {

		$query = "SELECT * FROM users WHERE userpath = '$userinfo'";

		$result = getDBContent($query);

		return $result;

	}

	function createPost ($message, $userid, $username) {

		$date = date("Y-m-d");

		$query = "INSERT INTO guestbook (message, userid, dateofpost, username) VALUES ('$message', '$userid', '$date', '$username')";

		insertDBContent($query);

	}

	function getPosts ($userid) {

		$query = "SELECT message, dateofpost, id, username, picpath FROM guestbook WHERE userid = '$userid' AND replyid IS NULL ORDER BY id DESC";

		$result = getDBContent($query);

		return $result;

	}

	function createComment ($comment, $userid, $username, $replyid) {

		$date = date("Y-m-d");

		$query = "INSERT INTO guestbook (message, userid, username, dateofpost, replyid) VALUES ('$comment', '$userid', '$username', '$date', '$replyid')";

		insertDBContent($query);

	}

	function getComments ($id) {

		$query = "SELECT message, dateofpost, id, replyid, username FROM guestbook WHERE replyid = '$id'";

		$result = getDBContent($query);

		return $result;

	}

	function searchForUser ($username) {

		$query = "SELECT username, userpath, picpath FROM users WHERE username LIKE '%$username%'";

		$result = getDBContent($query);

		return $result;

	}

	function getUserpath ($username) {

		$query = "SELECT userpath FROM users WHERE username LIKE '%$username%'";

		$result = getDBContent($query);

		return $result;

	}

	function createPicPath ($path, $userid) {

		$query = "UPDATE users SET picpath = '$path' WHERE id = '$userid'";

		insertDBContent($query);

	}

	function getPicPath ($userid) {

		$query = "SELECT picpath FROM users WHERE id = '$userid'";

		$result = getDBContent($query);

		return $result;

	}

	function createPostWithPic ($message, $userid, $username, $picpath) {

		$date = date("Y-m-d");

		$query = "INSERT INTO guestbook (message, userid, dateofpost, username, picpath) VALUES ('$message', '$userid', '$date', '$username', '$picpath')";

		insertDBContent($query);

	}

	function followUser ($userid, $followid) {

		$query = "INSERT INTO following (userid, followid) VALUES ('$userid', '$followid')";

		insertDBContent($query);

	}

	function checkFollower ($userid, $followid) {

		$query = "SELECT userid, followid FROM `following` WHERE `userid` = '$userid' AND `followid` = '$followid'";

		$result = getDBContent($query);

		return $result;

	}

	function unFollowUser ($userid, $followid) {

		$query = "DELETE FROM following WHERE `userid` = '$userid' AND `followid` = '$followid'";

		insertDBContent($query);

	}

	function followingUsers ($userid) {
			
		$query = "SELECT username, userpath, picpath FROM users WHERE id IN ( SELECT followid FROM following WHERE userid = '$userid' )";

		$result = getDBContent($query);

		return $result;

	}

	function getFollowers ($userid) {

		$query = "SELECT username, userpath, picpath FROM users WHERE id IN ( SELECT userid FROM following WHERE followid = '$userid')";

		$result = getDBContent($query);

		return $result;

	}

	function find_hashtags($tweet) {
	
		return preg_replace("/(#([\wåäöÅÄÖ]+))/", '<a href="searchresult.php?search=%23$2">$1</a>' , $tweet);

	}

	function getHashtags($hashtag) {

		$query = "SELECT * FROM guestbook WHERE message LIKE '%$hashtag%'";

		$result = getDBContent($query);

		return $result;

	}

	function find_at_tag_profile($username) {

		return preg_replace('/(?<=^|\s)@([a-z0-9_]+)/i', '<a href="profile.php">@$1</a>', $username);


	}

	function find_at_tag_viewuser ($username, $userpath) {

		return preg_replace('/(?<=^|\s)@([a-z0-9_]+)/i', '<a href="viewuser.php?username=' .$userpath. '">@$1</a>', $username);

	}

