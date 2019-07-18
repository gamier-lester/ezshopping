<?php
	require_once("library.php");
	require_once("../config/path.php");

	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 86400');

	header("Access-Control-Allow-Method: GET, POST, OPTIONS");
	header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

	$conn = new mysqli(DBSERVERNAME, DBUSERNAME, DBPASSWORD, DBNAME);

	if ($conn->connect_error) {
		die("Connection failed: ".$conn->connect_error);
	}

	if (!isset($_POST['message_id'])) {
		echo json_encode('invalid request');
		exit;
	}

	switch ($_POST['process']) {
		case 'message_read':
			$_POST['message_id'];
			$query = "UPDATE ecom_message_details SET status_id = 4 WHERE id = ".$_POST['message_id'];
			if ($conn->query($query) === TRUE) {
				echo json_encode('update successful');
			} elseif ($conn->query($query) === FALSE) {
				echo json_encode('update failed');
			}
			break;
	}
?>