<?php
	// constants
	// db connection
	define("DBSERVERNAME", "127.0.0.1");
	define("DBUSERNAME", "root");
	define("DBPASSWORD", "");
	define("DBNAME", "ecom");
	// define("DBSERVERNAME", "www.db4free.net");
	// define("DBUSERNAME", "ez_shopping_user");
	// define("DBPASSWORD", "foreverinlov3");
	// define("DBNAME", "ez_shopping_db");
	define("DEFAULTDP", "https://firebasestorage.googleapis.com/v0/b/ez-shopping-11c7a.appspot.com/o/images%2Favatar.png?alt=media&token=8239916f-7b64-4960-b0c2-b89a9cfb6b4f");

	// $conn = new mysqli(DBSERVERNAME, DBUSERNAME, DBPASSWORD, DBNAME);

	//Check Connection
	// if ($conn->connect_error) {
	// 	die("Connection failed: ".$conn->connect_error);
	// }

	function connect_db() {
		$conn = new mysqli(DBSERVERNAME, DBUSERNAME, DBPASSWORD, DBNAME);

		if ($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}

		return $conn;
	}

	// A function to sanitize the input
	function sanitize_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}