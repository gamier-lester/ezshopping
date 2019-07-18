<?php 
	session_start();
	require_once("library.php");
	require_once("../config/path.php");

	print_r($_POST);
	echo 'testing lang';
	$query = "INSERT INTO ecom_order (id, transaction_id, order_date, order_update, order_status, order_type, order_amount, user_id, item_id, item_price, item_quantity) VALUES ";
		$array_count = 1;
		$length = count($_SESSION['user_cart']['user_orders']);
		foreach($_SESSION['user_cart']['user_orders'] as $key => $value) {
			$item_id = $key;
			$item_price = $value['item_price'];
			$item_quantity = $value['order_quantity'];
			$order_amount = bcdiv(strval($item_price * $item_quantity), '1', 2);
			$query .= "(NULL, '$last_id', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '1', '2', '$order_amount', '$user_id', '$item_id', '$item_price', '$item_quantity')";
			if ($array_count != $length) {
				$query .= ', ';
			}
		}

		// echo $query;
		var_dump($query);
		// exit;
	/*
	if (!isset($_SESSION['user_credentials'])) {
		$_SESSION["error_login"] = "You must login first!";
		header("Location: ".ROOT_URL."/views/member/login.php");
		exit;
	} elseif (!isset($_SESSION['user_cart'])) {
		$_SESSION["error_message"] = "Your cart seems to be empty";
		header("Location: ".ROOT_URL."/views/shopping/cart.php");
		exit;
	} elseif (
		isset($_SESSION['user_credentials']) && 
		isset($_SESSION['user_cart']) && 
		$_SESSION['user_credentials']['user_id'] !== $_SESSION['user_cart']['user_id']) {
		$_SESSION['user_cart']['user_id'] = $_SESSION['user_credentials']['user_id'];
	}

	$conn = new mysqli(DBSERVERNAME, DBUSERNAME, DBPASSWORD, DBNAME);

	if ($conn->connect_error) {
		die("Connection failed: ".$conn->connect_error);
	}
	$user_id = $_SESSION['user_credentials']['user_id'];
	$transaction_code = sha1($user_id . date(DATE_RFC2822));
	$query = "INSERT INTO ecom_transaction (transaction_status, transaction_type, transaction_code, user_id) VALUES (1,2,'$transaction_code',$user_id)";
	// echo date(DATE_RFC2822);
	if ($conn->query($query) === TRUE) {
		// echo $conn->insert_id;
		$last_id = $conn->insert_id;
		// print_r($_SESSION);
		$query = "INSERT INTO ecom_order (id, transaction_id, order_date, order_update, order_status, order_type, order_amount, user_id, item_id, item_price, item_quantity) VALUES ";
		$array_count = 1;
		$length = count($_SESSION['user_cart']['user_orders']);
		foreach($_SESSION['user_cart']['user_orders'] as $key => $value) {
			$item_id = $key;
			$item_price = $value['item_price'];
			$item_quantity = $value['order_quantity'];
			$order_amount = bcdiv(strval($item_price * $item_quantity), '1', 2);
			$query .= "(NULL, '$last_id', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '1', '2', '$order_amount', '$user_id', '$item_id', '$item_price', '$item_quantity')";
			if ($array_count != $length) {
				$query .= ', ';
			}
		}
		// $conn->query($query);
		if ($conn->query($query) === TRUE) {
			unset($_SESSION['user_cart']);
			header('Location: '.$_SERVER['HTTP_REFERER']);
		}
	} else {
		echo $conn->error;
	}
	// unset($_SESSION['user_cart']);
	// header('Location: '.$_SERVER['HTTP_REFERER']);
?>