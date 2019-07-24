<?php 
	$pageTitle = 'View Cart';
	$page_css = '/views/shopping/cart/cart.css';
	$page_js = '/views/shopping/cart/cart.js';
	require_once("../../../partials/header.php");
?>

<div class="container py-3">
	<h3>
	  M Y C A R T
	  <small class="text-muted">- Please review your card before you place your order</small>
	</h3>
	<div id="cart-alert"></div>
	<div id="cart-container" class="row justify-content-around py-3"></div>
	<h3><i>Shop More?</i></h3>
	<p class="text-muted"><a id="go-back-button" href="#" class="card-link">Go back to Shopping</a></p>
	<div id="cart-related" class="row justify-content-around"></div>
</div>

<?php require_once("../../../partials/footer.php") ?>