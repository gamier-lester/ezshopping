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
			$query = "SELECT id, access_token, username FROM ecom_user_credentials WHERE username = '$username' AND password = '$password'";
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
			$query = "SELECT id, media_link FROM ecom_user_media WHERE user_id = $user_id AND type_id = 1 AND status_id = 1 ORDER BY id DESC LIMIT 1";
			$result = $conn->query($query);
			if ($result->num_rows > 0) {
				$response_data['media_link'] = array();
				$response_data['media_link'] = $result->fetch_assoc();
				$response_data['response_message']['message'] = 'Successfully retrieved media_link';
				$response_data['response_message']['success'] = TRUE;
			} else {
				$response_data['response_message']['message'] = "User doesn't have any media";
				$response_data['response_message']['success'] = FALSE;
			}
			$conn->close();
			echo json_encode($response_data);
			break;

		case 'fetch_user_data':
			$user_access_token = sanitize_input($_POST['request_member_access_token']);
			$user_id = sanitize_input($_POST['request_member_id']);
			$query = "SELECT uc.username as member_username, ud.user_email as member_email, ud.user_firstname as member_firstname, ud.user_lastname as member_lastname FROM ecom_user_credentials uc JOIN ecom_user_details ud ON uc.id = ud.user_id WHERE uc.id = $user_id AND uc.access_token = '$user_access_token'";
			$result = $conn->query($query);
			if ($result->num_rows > 0) {
				$response_data['member_details'] = array();
				$response_data['member_details'] = $result->fetch_assoc();
				$response_data['response_message']['message'] = 'Successfully retrieved member data';
				$response_data['response_message']['success'] = TRUE;
			} else {
				$response_data['response_message']['message'] = 'User doesn\'t have any existing record';
				$response_data['response_message']['success'] = FALSE;
			}
			$conn->close();
			echo json_encode($response_data);
			break;

		case 'fetch_user_message':
			$user_id = sanitize_input($_POST['request_member_id']);
			$query = "SELECT mcontent.message_content, mdetails.id as message_id, mdetails.sender_id, mdetails.receiver_id, mdetails.date_created as message_date,sdetails.user_email as sender_email, rdetails.user_email as receiver_email, status_details.status_name FROM ecom_message_details mdetails JOIN ecom_message_content mcontent ON mdetails.id = mcontent.message_id JOIN ecom_user_details sdetails ON mdetails.sender_id = sdetails.user_id JOIN ecom_user_details rdetails ON mdetails.receiver_id = rdetails.user_id JOIN ecom_status status_details ON mdetails.status_id = status_details.id WHERE mdetails.sender_id = $user_id OR mdetails.receiver_id = $user_id ORDER BY mdetails.id DESC LIMIT 5";
			$result = $conn->query($query);
			if ($result->num_rows > 0) {
				$response_data['member_messages'] = array();
				while ($row = $result->fetch_assoc()) {
					array_push($response_data['member_messages'], $row);
				}
				$response_data['response_message']['message'] = "Successfully retrieved: $result->num_rows message/s";
				$response_data['response_message']['success'] = TRUE;
			} else {
				$response_data['response_message']['message'] = "User doesn't have any messages";
				$response_data['response_message']['success'] = FALSE;
			}
			echo json_encode($response_data);
			$result->free();
			$conn->close();
			break;

		case 'update_primary_media':
			$user_id = sanitize_input($_POST['request_member_id']);
			$user_media = sanitize_input($_POST['request_member_media']);
			$query = "INSERT INTO ecom_user_media (user_id,	status_id, type_id, media_link) VALUE ($user_id, 1, 1, '$user_media')";
			 if ($conn->query($query) === TRUE) {
			 	$response_data['response_message']['message'] = "Successfully updated Profile Picture";
				$response_data['response_message']['success'] = TRUE;
			 } else {
				$response_data['response_message']['message'] = "Update failed: Please try again";
				$response_data['response_message']['success'] = FALSE;
			}
			$conn->close();
			echo json_encode($response_data);
			break;

			case 'update_user_data':
				$user_id = sanitize_input($_POST['request_member_id']);
				$user_email = sanitize_input($_POST['request_member_email']);
				$user_firstname = sanitize_input($_POST['request_member_firstname']);
				$user_lastname = sanitize_input($_POST['request_member_lastname']);
				$query = "SELECT * FROM ecom_user_details WHERE user_id = $user_id";
				$result = $conn->query($query);
				if ($result->num_rows > 0) {
					$query = "UPDATE ecom_user_details SET user_firstname = '$user_firstname', user_lastname = '$user_lastname', user_email = '$user_email' WHERE user_id = $user_id";
					if ($conn->query($query) === TRUE) {
						$response_data['response_message']['message'] = 'Successfully Updated user data!';
						$response_data['response_message']['success'] = TRUE;
					} else {
						$response_data['response_message']['message'] = 'Failed: couldn\'t update user data!';
						$response_data['response_message']['success'] = FALSE;
					}
				} else {
					$query = "INSERT INTO ecom_user_details (user_id, user_firstname, user_lastname, user_email) VALUES ($user_id, '$user_firstname', '$user_lastname', '$user_email')";
					if ($conn->query($query) === TRUE) {
						$response_data['response_message']['message'] = 'Successfully Created new user data!';
						$response_data['response_message']['success'] = TRUE;
					} else {
						$response_data['response_message']['message'] = 'Failed: couldn\'t create new user data!';
						$response_data['response_message']['success'] = FALSE;
					}
				}
				$conn->close();
				echo json_encode($response_data);
				break;
	}


?>