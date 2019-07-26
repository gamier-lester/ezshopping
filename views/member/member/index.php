<?php 
	$pageTitle = 'Member - Profile';
	$page_css = '/views/member/member/member.css';
	$page_js = '/views/member/member/member.js';
	require_once("../../../partials/header.php");
?>

<div class="container py-5">
	<div id="page-alert" class="col-lg-12"></div>
	<div class="col-lg-12">
		<button id="process-orders-button" class="btn btn-block btn-outline-success col-lg-4 ml-auto mb-2">Go back to shopping</button>
	</div>
	<div id="user-container" class="col-lg-12"></div>

	<div class="col-lg-12 mt-5">
		<p class="h4"><i>Merchant Items...</i></p>
	</div>
	<div id="item-container" class="col-lg-12 row justify-content-around"></div>
</div>

<?php require_once("../../../partials/footer.php") ?>