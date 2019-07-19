<?php 
	$pageTitle = "Profile";
	$section = "profile";
	$page_css = '/views/member/profile/profile.css';
	$page_js = '/views/member/profile/profile.js';
	$use_firebase = true;
	require_once("../../../partials/header.php");
?>

<div class="container">
	<section class="row justify-content-center py-5">
		<div class="col-lg-3">
			<div id="profile-container" class="sticky-top">
				<div id="profile-alert-container" class="col-lg-12"></div>
				<div id="profile-media-container" class="image-overlay-container"></div>
			</div>
		</div>
		
	</section>
</div>

<?php require_once("../../../partials/footer.php") ?>