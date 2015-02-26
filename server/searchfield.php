<?php 
	
	$searchresult = "";
	$searcherror  = "";
	$search  = "";
	$hashtag = "";
	$result  = "";
	$userresult = array();
	$hashtagresult = array();
 
	if(!empty($_GET["search"])) {

		$search = $_GET["search"];

		if ($search[0] !== '#') {

			$searchresult = searchForUser($search);

		} else {

			$hashtag = getHashtags($search);

		}

		if ($searchresult) {
					
			foreach ($searchresult as $userinfo) {

				$userresult[] = $userinfo;

			}

		} else {

			if ($hashtag) {

				foreach ($hashtag as $value) {

					$hashtagresult[] = $value;
					
				}

			} else {

				$searcherror = "No matches!";
				
			}

		}

	} else {

		$searcherror = "Empty searchfield";

	}

