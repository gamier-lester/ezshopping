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
		case 'add_item':
			$user_id = sanitize_input($_POST['request_member_id']);
			$item_description = sanitize_input($_POST['request_item_description']);
			$item_media = sanitize_input($_POST['request_item_media']);
			$item_name = sanitize_input($_POST['request_item_name']);
			$item_price = sanitize_input($_POST['request_item_price']);
			$item_price = bcdiv(strval($item_price), '1', 2);
			$query = "INSERT INTO ecom_item_basics (user_id, status_id, type_id, name, description, price) VALUES ($user_id, 1, 1, '$item_name', '$item_description', '$item_price')";
			if ($conn->query($query) === TRUE) {
				$item_id = $conn->insert_id;
				$query = "INSERT INTO ecom_item_media (item_id, status_id, type_id, media_link) VALUES ($item_id, 1, 1, '$item_media')";
				if ($conn->query($query) === TRUE) {
					$response_data['response_message']['message'] = 'Successfully added new item!';
					$response_data['response_message']['success'] = TRUE;
				} else {
					$response_data['response_message']['message'] = 'Item image upload is unsuccessful';
					$response_data['response_message']['success'] = TRUE;
				}
			} else {
				$response_data['response_message']['message'] = 'Failed: Item could not be added';
				$response_data['response_message']['success']= FALSE;
			}
			$conn->close();
			echo json_encode($response_data);
			break;

		case 'fetch_one':
			$item_id = sanitize_input($_POST['request_item_id']);
			$query = "SELECT id, name, price FROM ecom_item_basics WHERE id = $item_id";
			$result = $conn->query($query);
			if ($result->num_rows > 0) {
				$response_data['item_detail'] = array();
				$response_data['item_detail'] = $result->fetch_assoc();
				$response_data['response_message']['message'] = 'Successfully retrieved data';
				$response_data['response_message']['success'] = TRUE;
			} else {
				$response_data['response_message']['message'] = 'No data found on record';
				$response_data['response_message']['success'] = FALSE;
			}
			echo json_encode($response_data);
			$result->free();
			$conn->close();
			break;

		case 'fetch_user_items':
			$user_id = sanitize_input($_POST['request_member_id']);
			$query = "SELECT itemRow.id as item_id, itemRow.name as item_name, itemRow.description as item_description, itemRow.price as item_price, mediaRow.media_link FROM ecom_item_basics itemRow JOIN ecom_item_media mediaRow ON itemRow.id = mediaRow.item_id && mediaRow.type_id = 1 WHERE itemRow.user_id = $user_id";
			$result = $conn->query($query);
			if ($result->num_rows > 0) {
				$response_data['items'] = array();
				while ($row = $result->fetch_assoc()) {
					array_push($response_data['items'], $row);
				}
				$response_data['response_message']['message'] = "Successfully retrieved $result->num_rows items";
				$response_data['response_message']['success'] = TRUE;
			} else {
				$response_data['response_message'] = "No data retrieved";
				$response_data['response_message']['success'] = FALSE;
			}
			echo json_encode($response_data);
			$result->close();
			$conn->close();
			break;

		case 'update_item_details':
			$user_id = sanitize_input($_POST['request_member_id']);
			$item_id = sanitize_input($_POST['request_item_id']);
			$item_name = sanitize_input($_POST['request_item_name']);
			$item_description = sanitize_input($_POST['request_item_description']);
			$item_price = sanitize_input($_POST['request_item_price']);
			$item_price = bcdiv(strval($item_price), '1', 2);
			$query = "UPDATE ecom_item_basics SET name = '$item_name', description = '$item_description', price = '$item_price' WHERE user_id = $user_id AND id = $item_id";
			if ($conn->query($query) === TRUE) {
				$response_data['response_message']['message'] = 'Successfully Updated item details';
				$response_data['response_message']['success'] = TRUE;
			} else {
				$response_data['response_message']['message'] = 'Failed: Update for item detail failed';
				$response_data['response_message']['success'] = FALSE;
			}
			echo json_encode($response_data);
			$conn->close();
			break;
	}


?>