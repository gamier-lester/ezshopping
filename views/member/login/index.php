<?php 
	$pageTitle = "Login";
	$section = "login";
	$page_css = '/views/member/login/login.css';
	$page_js = '/views/member/login/login.js';
	require_once("../../../partials/header.php");
?>

<div class="container py-5">
	<section class="row justify-content-center">
		<div class="col-md-6">
			<div id="alert-container" class="col-lg-12 text-center"></div>
			<h2> Login 🧛 </h2>
			<form>
				<div class="form-group">
					<label for="username"> Username </label>
					<input id="username" type="text" name="username" class="form-control">
				</div>
				<div class="form-group">
					<label for="password"> Password </label>
					<input id="password" type="password" name="password" class="form-control text-danger">
				</div>
				<button id="login-button" type="button" class="btn btn-success btn-block" onclick="login(this)"> Login </button>
			</form>
		</div>
	</section>
</div>


<?php require_once("../../../partials/footer.php") ?>