<?php

	$message = "";
	$comment = "";

	require_once("data.php");

	$userid   = $_SESSION["userdata"]["id"];
	$username = $_SESSION["userdata"]["username"];

	$username = substr_replace($username, "@$username", 0);

	if($_SERVER["REQUEST_METHOD"] == "POST") {

		if (!empty($_POST["message"]) && $_POST["comment"] == "") {

			$message = $_POST["message"];

			if (strlen($message) < 200) {

				if(!$_FILES["upload"]["error"] == 4) {
					
					if ($_FILES["upload"]["error"] == 0) {

						$file  = $_FILES["upload"]["tmp_name"];
						$size  = $_FILES["upload"]["size"];

						$data = getimagesize($file);

						if ($data) {

							if ($size < 500000) {

							$end = explode(".", $_FILES["upload"]["name"])[1];

							$uploads_dir = "img/post/";

							$name = substr(md5(rand()), 0, 7);

							$picname = $name. "." .$end;
			
							move_uploaded_file($file, $uploads_dir.$picname);

							createPostWithPic($message, $userid, $username, $picname);

							} else {

								$_SESSION["error"] = "Maximum size is 0.5MB";

							}

						} else {

							$_SESSION["error"] = "Only images are allowed";

						}

					}

				} else {

					createPost($message, $userid, $username);

		 		}

		 	} else {

		 		$_SESSION["error"] = "200 characters is the maximum";

		 	}

		} 

		if (!empty($_POST["comment"]) && $_POST["message"] == "") {

			$comment = $_POST["comment"];
			$id = $_POST["id"];

			if (strlen($comment) < 200) {
			
	 			createComment($comment, $userid, $username, $id);

	 		} else {

	 			$_SESSION["error"] = "200 characters is the maximum";

	 		}

		} 

		if (empty($_POST["comment"]) && empty($_POST["message"])) {

			$_SESSION["error"] = "Please post a message or a comment";

		}

	}

	 

 	

 	