<?php 

	define("HOST", "localhost");
	define("USERNAME", "root");
	define("PASSWORD", "root");
	define("DATABASE", "slutuppgift");

	function DBConnect () {
		$con = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USERNAME, PASSWORD);
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $con;
	}

	function getDBContent ($query) {
		try {
			$con = DBConnect();
			$stmt = $con->prepare($query);
			$stmt->execute();
			$array = [];
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$array[] = $row;
			}
			if ($array !== "") {
				return $array;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			print 'ERROR: ' . $e->getMessage();
		}
	}

	function getDBContentRow ($query) {
		try { 
			$con = DBConnect();
			$stmt = $con->prepare($query); 
			$stmt->execute(); 
			$row = $stmt->fetch();
			return $row;
			} catch (PDOException $e) {
				print 'ERROR: ' . $e->getMessage();
			}

	}

	function insertDBContent ($query) {
		try {
			$con = DBConnect();
			$stmt = $con->prepare($query);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			print 'ERROR: ' . $e->getMessage();
		}
	}

?>