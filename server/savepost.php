<?php

	$message = "";
	$comment = "";

	$userid   = $_SESSION["userdata"]["id"];
	$username = $_SESSION["userdata"]["username"];

	$username = substr_replace($username, "@$username", 0);

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		if ($_POST["action"] == "post") {

			$message = $_POST["message"];

			if ($_POST["message"] == "" && $_FILES["upload"]["error"] == 4) { 

				$error = "Please post something!";

			}

			if (!empty($_POST["message"]) && $_FILES["upload"]["error"] == 4) {

				if (strlen($_POST["message"]) < 200) {

					createPost($message, $userid, $username);

				} else {

					$error = "Maximum 200 characters";

				}

			}

			if (!$_FILES["upload"]["error"] == 4 && !empty($_POST["message"])) {

				if (strlen($_POST["message"]) < 200) {
					
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

								$error = "Maximum size is 0.5 MB";

							}

						} else {

							$error = "Only images are allowed";

						}

					}

				} else {

					$error = "Maximum 200 characters";

				}

			}

			if (!$_FILES["upload"]["error"] == 4 && $_POST["message"] == "") {
					
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

						createPostPic($userid, $username, $picname);

						} else {

							$error = "Maximum size is 0.5 MB";

						}

					} else {

						$error = "Only images are allowed";

					}

				}

			}

		}

		if ($_POST["action"] == "comment") {

			$comment = $_POST["comment"];
			$id = $_POST["id"];

			if ($comment == "") {

	 			$error = "Please make a comment";

	 		}

			if (!empty($comment)) {

				if (strlen($comment) < 200) {
				
		 			createComment($comment, $userid, $username, $id);

		 		} else {

		 			$error = "Maximum 200 characters";

		 		}

	 		}
			
		}

	}

	 

 	

 	