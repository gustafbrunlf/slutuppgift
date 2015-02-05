<?php

$userid = $_SESSION["userdata"]["id"];

if (isset($_FILES["upload"])) {

	if ($_FILES["upload"]["error"] == 0) {

		$file  = $_FILES["upload"]["tmp_name"];
		$size  = $_FILES["upload"]["size"];

		$data = getimagesize($file);

		if ($data) {

			$name = substr(md5(rand()), 0, 7);

			$path = "profile/".$name.".jpg";
			
			move_uploaded_file($file, $path);

			createPicPath($path, $userid);

			$_SESSION["error"] = "Uploaded";


		} else {

			$_SESSION["error"] = "Only images are allowed";

		}

	} else {

		$_SESSION["error"] = "Upload error";

	}

}