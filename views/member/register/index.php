<?php 
	$pageTitle = 'Register - Member';
	$page_css = '/views/member/register/register.css';
	$page_js = '/views/member/register/register.js';
	require_once("../../../partials/header.php");
?>

<div class="container py-5">
	<section class="row justify-content-center">
		<div id="alert-container" class="col-lg-12"></div>
		<div class="col-md-6">
			<h2> Register 🧛 </h2>
			<form>
				<div class="form-group">
					<label for="username"> Username </label>
					<input id="username" type="text" name="username" class="form-control">
				</div>
				<div class="form-group">
					<label for="password"> Password </label>
					<input id="password" type="password" name="password" class="form-control text-danger">
				</div>
				<button id="register-button" type="button" class="btn btn-success btn-block" onclick="register(this)"> Submit </button>
			</form>
		</div>
	</section>
</div>

<?php require_once("../../../partials/footer.php") ?>