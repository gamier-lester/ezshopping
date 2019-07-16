<?php
	$pageTitle = "My Cart";
	$section = "cart";
	require_once("../../partials/header.php");
?>

	<div class="container py-5">
	<?php if (isset($_SESSION['user_cart'])): ?>
		<?php foreach($_SESSION['user_cart']['user_orders'] as $key => $value) { ?>
			<?php print_r($key); ?>
			<?php print_r($value); ?>
			<br>
		<?php } ?>
		<a href="<?php echo get_url(); ?>/controllers/process.add-orders.php">Place orders!</a>
	<?php elseif (!isset($_SESSION['user_cart'])): ?>
		<h4 class="h4">Cart is empty</h4>
	<?php endif; ?>
	</div>

<?php require_once("../../partials/footer.php") ?>