<?php 
	session_start();
	require_once("library.php");
	require_once("../config/path.php");

	$conn = new mysqli(DBSERVERNAME, DBUSERNAME, DBPASSWORD, DBNAME);

	if ($conn->connect_error) {
		die("Connection failed: ".$conn->connect_error);
	}

	switch ($_POST['process']) {
		case 'fetch_one':
			$request_data = array();
			$query = "SELECT i.id, i.name, i.price, i.description, m.media_link, u.user_firstname AS merchant_firstname, u.user_id AS merchant_id, s.status_name AS item_status, t.type_name AS item_type FROM ecom_item_basics i JOIN ecom_item_media m ON i.id = m.item_id JOIN ecom_user_details u ON i.user_id = u.user_id JOIN ecom_status s ON i.status_id = s.id JOIN ecom_type t ON i.type_id = t.id WHERE i.id = ".$_POST['item_id'];
			$result = $conn->query($query);
			$request_data['item_data'] = $result->fetch_assoc();

			$query = "SELECT m.media_link, t.type_name as media_type FROM ecom_item_media m JOIN ecom_type t ON m.type_id = t.id WHERE m.item_id = ".$request_data['item_data']['id'];
			$result = $conn->query($query);
			$media_array = array();
			while ($row = $result->fetch_assoc()) {
				array_push($media_array, $row);
			}
			$request_data['item_media'] = $media_array;

			$query = "SELECT * FROM ecom_user_details WHERE user_id = ".$request_data['item_data']['merchant_id'];
			$result = $conn->query($query);
			$request_data['item_merchant'] = $result->fetch_assoc();

			$query = "SELECT i.id, i.name, m.media_link, u.user_id FROM ecom_item_basics i JOIN ecom_item_media m ON i.id = m.item_id && m.type_id = 1 JOIN ecom_user_details u ON i.user_id = u.user_id WHERE u.user_id =".$request_data['item_data']['merchant_id'];
			$result = $conn->query($query);
			$related_search_array = array();
			while ($row = $result->fetch_assoc()) {
				array_push($related_search_array, $row);
			}
			$request_data['item_related_search'] = $related_search_array;

			echo json_encode($request_data);
			break;
	}
?>