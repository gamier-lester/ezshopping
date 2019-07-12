<?php 
	$pageTitle = "Login";
?>


<?php 
	require_once("../partials/header.php");
	
	if (isset($_SESSION["user"])) {
		header("Location: ".ROOT_URL."/index.php");
	}
?>

<div class="container py-5">
	<section class="row justify-content-center">

		<div class="col-md-6">
			<h2> Login 🧛 </h2>

			<form action="<?php get_url() ?>/controllers/process.login.php" method="POST">
				<div class="form-group">
					<label for="username"> Username </label>
					<input id="username" type="text" name="username" class="form-control">
				</div>

				<!-- <div class="form-group">
					<label for="email"> Email </label>
					<input id="email" type="emain" name="email" class="form-control">
				</div> -->

				<div class="form-group">
					<label for="password"> Password </label>
					<input id="password" type="password" name="password" class="form-control text-danger">
				</div>

				<button type="submit" class="btn btn-success btn-block"> Submit </button>
			</form>

		</div>

	</section>
</div>


<?php require_once("../partials/footer.php") ?>