<?php 
	$pageTitle = 'Member - Order';
	$page_css = '/views/member/order/order.css';
	$page_js = '/views/member/order/order.js';
	require_once("../../../partials/header.php");
?>

<div class="container py-5">
	<div class="jumbotron jumbotron-fluid mt-2">
	  <h1 class="mx-5">Transaction Page</h1>
	  <p class="lead mx-5">View your orders and transactions here!</p>
	  <hr class="my-4 mx-5">
	  <p class="mx-5">Thank you for shopping with us! ~ez-shopping team</p>
	</div>
	<div id="transaction-link" class="row justify-content-around m-3"></div>
	<div id="transaction_container" class="col-lg-12"></div>
</div>

<?php require_once("../../../partials/footer.php") ?>