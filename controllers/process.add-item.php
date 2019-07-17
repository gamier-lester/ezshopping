<?php
	session_start();
	require_once("library.php");
	require_once("../config/path.php");

	if (!isset($_SESSION['user_credentials']['user_id'])) {
		$_SESSION['response_message']['message'] = 'You must login first!';
		$_SESSION['response_message']['success'] = FALSE;
		header('Location: '.ROOT_URL."/views/member/login.php");
	}

	$conn = new mysqli(DBSERVERNAME, DBUSERNAME, DBPASSWORD, DBNAME);
	$user_id = $_SESSION['user_credentials']['user_id'];
	$item_name = $_POST['form_item_name'];
	$item_description = $_POST['form_item_description'];
	$item_price = $_POST['form_item_price'];
	$item_media = $_POST['form_item_media_primary'];

	if ($conn->connect_error) {
		die("Connection failed: ".$conn->connect_error);
	}

	$query = "INSERT INTO ecom_item_basics (user_id,status_id,type_id,name,description,price) VALUES ('$user_id', 1, 2, '$item_name', '$item_description', '$item_price')";
	$conn->query($query);
	$item_id = $conn->insert_id;

	$query = "INSERT INTO ecom_item_media (item_id, status_id, type_id, media_link) VALUES ('$item_id', 1, 1, '$item_media')";
	$conn->query($query);

	$_SESSION['response_message']['message'] = 'Item added successfully!';
	$_SESSION['response_message']['success'] = TRUE;

	header('Location: '.$_SERVER['HTTP_REFERER']);
	
?>