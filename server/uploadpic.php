<?php

	$userid = $_SESSION["userdata"]["id"];

	if($_SERVER["REQUEST_METHOD"] == "POST") {

		$message = $_POST["message"];

		if (isset($_POST["message"])) {

			setUserInfo($userid, $message);

		}

		if (!$_FILES["upload"]["error"] == 4) {

			if ($_FILES["upload"]["error"] == 0) {

				$picpath = getPicPath($userid);

				if ($picpath[0]["picpath"]) { 

					$img = "img/profile/" . $picpath[0]["picpath"];
					unlink($img);

				}

				$file  = $_FILES["upload"]["tmp_name"];
				$size  = $_FILES["upload"]["size"];

				$data = getimagesize($file);

				if ($data) {

					if ($size < 1024*1024) {

						$end = explode(".", $_FILES["upload"]["name"])[1];

						$uploads_dir = "img/profile/";

						$name = substr(md5(rand()), 0, 7);

						$picname = $name. "." .$end;

						echo __FILE__."<br>";
						echo dirname(__FILE__)."<br>";
						echo __DIR__."<br>";

						if(file_exists($file)) {
						   echo "file uploaded to temp dir<br>";
						} else {
						   echo "file upload failed<br>";
						}
						
						if (move_uploaded_file($file, $uploads_dir.$picname)) {
						   echo "upload complete<br>";
						} else {
						   echo "move_uploaded_file failed<br>";
						}

						createPicPath($picname, $userid);

						$_SESSION["error"] = "Uploaded";

					} else {

						$_SESSION["error"] = "Maximum size is 1 MB";

					}


				} else {

					$_SESSION["error"] = "Only images are allowed";

				}

			} else {

				$_SESSION["error"] = "Upload error";

			}

		}



	}