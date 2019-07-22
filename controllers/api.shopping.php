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

	switch ($_POST['request_process']) {
		case 'fetch_one':
			$query = "SELECT i.id, i.name, i.price, i.description, m.media_link, u.user_firstname AS merchant_firstname, u.user_id AS merchant_id, s.status_name AS item_status, t.type_name AS item_type FROM ecom_item_basics i JOIN ecom_item_media m ON i.id = m.item_id JOIN ecom_user_details u ON i.user_id = u.user_id JOIN ecom_status s ON i.status_id = s.id JOIN ecom_type t ON i.type_id = t.id WHERE i.id = ".$_POST['request_item_id'];
			$result = $conn->query($query);
			$response_data['item_data'] = $result->fetch_assoc();

			$query = "SELECT m.media_link, t.type_name as media_type FROM ecom_item_media m JOIN ecom_type t ON m.type_id = t.id WHERE m.item_id = ".$response_data['item_data']['id'];
			$result = $conn->query($query);
			$media_array = array();
			while ($row = $result->fetch_assoc()) {
				array_push($media_array, $row);
			}
			$response_data['item_media'] = $media_array;

			$query = "SELECT u.user_id, u.user_firstname, u.user_lastname, u.user_email, m.media_link, uc.date_created as user_date_joined FROM ecom_user_details u LEFT JOIN ecom_user_media m ON m.user_id = u.user_id JOIN ecom_user_credentials uc ON u.user_id = uc.id WHERE u.user_id = ".$response_data['item_data']['merchant_id'] ." LIMIT 1";
			$result = $conn->query($query);
			$response_data['item_merchant'] = $result->fetch_assoc();

			$query = "SELECT i.id, i.name, m.media_link, u.user_id FROM ecom_item_basics i JOIN ecom_item_media m ON i.id = m.item_id && m.type_id = 1 JOIN ecom_user_details u ON i.user_id = u.user_id WHERE u.user_id =".$response_data['item_data']['merchant_id'] . " LIMIT 3";
			$result = $conn->query($query);
			$related_search_array = array();
			while ($row = $result->fetch_assoc()) {
				array_push($related_search_array, $row);
			}
			$response_data['item_related_search'] = $related_search_array;
			$response_data['response_message']['message'] = 'Fetch successful';
			$response_data['response_message']['success'] = TRUE;
			echo json_encode($response_data);
			$result->free();
			$conn->close();
			break;

		case 'fetch_default':
			$order = isset($_POST['request_order']) ? $_POST['request_order'] : 'ASC';
			$limit = isset($_POST['request_limit']) ? $_POST['request_limit'] : 10;
			$offset = isset($_POST['request_offset']) ? $_POST['request_offset'] : 0;
			$query = "SELECT i.id, i.name, i.price, i.description, m.media_link, u.user_firstname AS merchant_firstname, s.status_name AS item_status, t.type_name AS item_type FROM ecom_item_basics i JOIN ecom_item_media m ON i.id = m.item_id && m.type_id = 1 JOIN ecom_user_details u ON i.user_id = u.user_id JOIN ecom_status s ON i.status_id = s.id JOIN ecom_type t ON i.type_id = t.id ORDER BY i.price $order LIMIT $limit OFFSET $offset";
			$result = $conn->query($query);
			if ($result->num_rows > 0) {
				$response_data['items'] = array();
				while ($row = $result->fetch_assoc()) {
					$result_array = $row;
					array_push($response_data['items'], $result_array);
				}
			}
			echo json_encode($response_data);
			$result->free();
			$conn->close();
			break;

		case 'fetch_count':
			$query = "SELECT COUNT(*) FROM ecom_item_basics";
			$result = $conn->query($query);
			$response_data['item_count'] = intval($result->fetch_assoc()['COUNT(*)']);
			echo json_encode($response_data);
			$result->free();
			$conn->close();
			break;
	}
?>