<?php
	// constants
	// db connection
	define("DBSERVERNAME", "127.0.0.1");
	define("DBUSERNAME", "root");
	define("DBPASSWORD", "");
	define("DBNAME", "ecom");

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