<?php 
	session_start();
	require_once("library.php");
	require_once("../config/path.php");

	if (!isset($_SESSION['user_credentials'])) {
		$_SESSION['add-to-cart_error-message'] = 'You must login first!';
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit;
	}

	$user_id = $_SESSION['user_credentials']['user_id'];
	$item_id = $_POST['item_id'];
	$item_price = $_POST['item_price'];
	$order_quantity = $_POST['order_quantity'];

	if (!isset($_SESSION['user_cart'])) {
		$_SESSION['user_cart'] = array();
		$_SESSION['user_cart']['user_id'] = $user_id;
		$_SESSION['user_cart']['user_orders'] = array();
	}

	if (!isset($_SESSION['user_cart']['user_orders'][$item_id])) {
		$_SESSION['user_cart']['user_orders'][$item_id] = array(
			'item_price' => $item_price,
			'order_quantity' => $order_quantity
		);
	} elseif (isset($_SESSION['user_cart']['user_orders'][$item_id])) {
		$tmp_qty = $_SESSION['user_cart']['user_orders'][$item_id]['order_quantity'];
		$new_qty = intval($tmp_qty) + intval($order_quantity);
		$_SESSION['user_cart']['user_orders'][$item_id] = array(
			'item_price' => $item_price,
			'order_quantity' => $new_qty
		);
	}
	$_SESSION['add-to-cart_success-message'] = 'Added to cart!';
	header('Location: '.$_SERVER['HTTP_REFERER']);
	// print_r($_SESSION['user_cart']);
	// print_r($_POST);
?>