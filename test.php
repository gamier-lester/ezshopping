<?php 
	$pageTitle = "Test";
	$section = "index";
?>

<?php require_once("partials/header.php") ?>

	<div class="container py-5">
		<section class="row">
			<div class="col-lg-3">
				<div class="row justify-content-around">
					<img src="http://localhost:8080/e-commerce/assets/images/fox.png" class="col-lg-12">
					<img src="http://localhost:8080/e-commerce/assets/images/profile.jpg" class="col-lg-3">
					<img src="http://localhost:8080/e-commerce/assets/images/sandbox.png" class="col-lg-3">
					<img src="http://localhost:8080/e-commerce/assets/images/evilmonkey.png" class="col-lg-3">
					<div class="col-lg-12">PRODUCT PRICE</div>
					<div class="col-lg-12">
						<form>
							<div class="form-group">
								<label for="order_quantity">Quantity</label>
								<input type="number" name="order_quantity" id="order_quantity" class="form-control" placeholder="1">
							</div>
							<button class="btn btn-block btn-success">ADD TO CART</button>
							<button class="btn btn-block">BUY NOW!</button>
						</form>
					</div>
				</div>
			</div>
			<div class="col-lg-9">
				<h4 class="h4">PRODUCT NAME</h4>
				<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. PRODUCT DESCRIPTION</p>
				<p class="secondary">VENDOR NAME</p>
			</div>
		</section>
	</div>
		
<?php require_once("partials/footer.php") ?>