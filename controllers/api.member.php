<?php 
	session_start();
	require_once("library.php");
	require_once("../config/path.php");

	$conn = new mysqli(DBSERVERNAME, DBUSERNAME, DBPASSWORD, DBNAME);

	if ($conn->connect_error) {
		die("Connection failed: ".$conn->connect_error);
	}

	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 86400');

	header("Access-Control-Allow-Method: GET, POST, OPTIONS");
	// header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

	$response_data = array();
	$response_data['response_message'] = array();
	switch ($_POST['request_process']) {
		case 'login':
			$username = sanitize_input($_POST['request_member_username']);
			$password = sha1(sanitize_input($_POST['request_member_password']));
			$query = "SELECT id, access_token FROM ecom_user_credentials WHERE username = '$username' AND password = '$password'";
			$result = $conn->query($query);
			if ($result->num_rows > 0) {
				$response_data['member'] = $result->fetch_assoc();
				$response_data['response_message']['message'] = 'Successfully Logged In';
				$response_data['response_message']['success'] = TRUE;
			} else {
				$response_data['response_message']['message'] = 'Failed: Invalid credentials';
				$response_data['response_message']['success'] = FALSE;
			}
			$result->free();
			$conn->close();
			echo json_encode($response_data);
			break;

		case 'register':
			$username = sanitize_input($_POST['request_member_username']);
			$password = sha1(sanitize_input($_POST['request_member_password']));
			$access_token = sha1($username);
			$query = "SELECT * FROM ecom_user_credentials WHERE username = '$username'";
			$result = $conn->query($query);
			if ($result->num_rows > 0) {
				$response_data['response_message']['message'] = 'Failed: User already exist';
				$response_data['response_message']['success'] = FALSE;
			} else {
				$query = "INSERT INTO ecom_user_credentials (access_token, username, password) VALUES ('$access_token', '$username', '$password')";
				if ($conn->query($query) === TRUE) {
					$response_data['response_message']['message'] = "Successfully registered $username";
					$response_data['response_message']['success'] = TRUE;
				} else {
					$response_data['response_message']['message'] = "Registration failed: Please try again";
					$response_data['response_message']['success'] = FALSE;
				}
			}
			$conn->close();
			echo json_encode($response_data);
			break;
		case 'fetch_primary_media':
			$user_id = sanitize_input($_POST['request_member_id']);
			$query = "SELECT id, media_link FROM ecom_user_media JOIN WHERE user_id = $user_id AND type_id = 1 AND status_id = 1 LIMIT 1";
			if ($result = $conn->query($query)) {
				while ($row = $result->fetch_assoc()) {
					$response_data['media_link'] = $row;
				}
				$response_data['response_message']['message'] = 'Successfully retrieved media_link';
				$response_data['response_message']['success'] = TRUE;
			} else {
				$response_data['response_message']['message'] = "User doesn't have any media";
				$response_data['response_message']['success'] = FALSE;
			}
			$conn->close();
			echo json_encode($response_data);
			break;

	}


?>