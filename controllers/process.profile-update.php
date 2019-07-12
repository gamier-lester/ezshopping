<?php 
	session_start();
	require_once("library.php");
	require_once("../config/path.php");

	$user_id = $_POST["user_id"];
	$user_firstname = $_POST["firstname"];
	$user_lastname = $_POST["lastname"];
	$user_email = $_POST["email"];

	$conn = new mysqli(DBSERVERNAME, DBUSERNAME, DBPASSWORD, DBNAME);

	if ($conn->connect_error) {
		die("Connection failed: ".$conn->connect_error);
	}

	$query = "SELECT * FROM ecom_user_details WHERE user_id LIKE '$user_id'";
	$result = $conn->query($query);

	if ($result->num_rows > 0) {
		$query = "UPDATE ecom_user_details
			SET user_firstname = '$user_firstname',
			user_lastname = '$user_lastname',
			user_email = '$user_email'
			WHERE user_id LIKE '$user_id'";
			
			if($conn->query($query) === TRUE) {
				echo 'update true';
			} else {
				echo 'update false';
			}
	} else {
		$query = "INSERT INTO ecom_user_details (user_id, user_firstname, user_lastname, user_email)
			VALUES ('$user_id', '$user_firstname', '$user_lastname', '$user_email')";
		if($conn->query($query) === TRUE) {
			echo 'insert true';
		} else {
			echo 'insert false';
		}
	}
?>