<?php 
	$pageTitle = "Register";
	$section = "register";
?>


<?php 
	require_once("../../partials/header.php");
	
	if (isset($_SESSION["user_credentials"])) {
		header("Location: ".ROOT_URL."/views/profile.php");
	}
?>

<div class="container py-5">
	<section class="row justify-content-center">

		<div class="col-md-6">
			<h2> Register 🧛 </h2>
			<?php if(isset($_SESSION["error_registration"])): ?>
			<p class="lead"><?php echo $_SESSION["error_registration"]; ?></p>
			<?php session_unset($_SESSION["error_registration"]); endif; ?>

			<form action="<?php get_url() ?>/controllers/process.register.php" method="POST">
				<div class="form-group">
					<label for="username"> Username </label>
					<input id="username" type="text" name="username" class="form-control">
				</div>

				<div class="form-group">
					<label for="password"> Password </label>
					<input id="password" type="password" name="password" class="form-control text-danger">
				</div>

				<button type="submit" class="btn btn-success btn-block"> Submit </button>
			</form>

		</div>

	</section>
</div>


<?php require_once("../../partials/footer.php") ?>