<?php 
	session_start();
	require_once("library.php");
	require_once("../config/path.php");

	if(isset($_POST["username"]) && isset($_POST["password"])) {
		$username = $_POST["username"];
		$password = $_POST["password"];
		$conn = new mysqli(DBSERVERNAME, DBUSERNAME, DBPASSWORD, DBNAME);

		if ($conn->connect_error) {
			die("Connection failed: ".$conn->connect_error);
		}

		$query = "SELECT id, username, password FROM ecom_user_credentials WHERE username LIKE '$username'";
		$result = $conn->query($query);

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				// $user_credentials->user_username = $row["username"];
				// $user_credentials->user_password = $row["password"];
				// $_SESSION["user_credentials"] = $user_credentials;
				// header("Location: ".ROOT_URL."/views/profile.php");
				if ($row["password"] === sha1(sanitize_input($password))) {
					$user_credentials = array(
						"user_id" => $row["id"],
						"user_username" => $row["username"],
						"user_password" => $row["password"]
					);
					$_SESSION["user_credentials"] = $user_credentials;
					header("Location: ".ROOT_URL."/views/member/profile.php");
				} else {
					$_SESSION["error_login"] = "User data does not match";
					header("Location: ".ROOT_URL."/views/member/login.php");
				}
			}
		} else {
			$_SESSION["error_login"] = "User does not exist";
			header("Location: ".ROOT_URL."/views/member/login.php");
		}
	}
?>