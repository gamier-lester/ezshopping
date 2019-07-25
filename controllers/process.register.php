<?php 
	session_start();
	require_once("library.php");
	require_once("../config/path.php");

	if(isset($_POST["username"]) && isset($_POST["password"])) {
		$username = sanitize_input($_POST["username"]);
		$password = sha1(sanitize_input($_POST["password"]));

		$conn = new mysqli(DBSERVERNAME, DBUSERNAME, DBPASSWORD, DBNAME);

		if ($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}
		$query = "INSERT INTO ecom_user_credentials (username, password)
			VALUES ('$username', '$password')";

		if ($conn->query($query) === TRUE) {
			$_SESSION["success_registration"] = "Successfully registered $username";
			header("Location: ".ROOT_URL."/views/member/login.php");
		} else {
			$_SESSION["error_registration"] = "There has been error on the registration of your account: $conn->error";
			header("Location: ".ROOT_URL."/views/member/login.php");
		}

		// close database connection
		$conn->close();
	}
?>