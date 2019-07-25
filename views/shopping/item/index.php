<?php 
	$pageTitle = 'View Item';
	$page_css = '/views/shopping/item/item.css';
	$page_js = '/views/shopping/item/item.js';
	require_once("../../../partials/header.php");
?>

	<div class="container py-3">
		<div class="row">
			<div class="col-lg-12">
				<button id="go-back-button" class="btn btn-block btn-outline-primary col-lg-4 ml-auto">Go back to Shopping</button>
			</div>
			<div id="page-alert" class="col-lg-12 mt-2"></div>
			<div id="item-profile" class="col-lg-3">
				Nothing to Display
			</div>

			<div id="item-details" class="col-lg-9"></div>
			<div class="col-lg-12 mt-5">
				<p class="h4"><i>Items from the same store...</i></p>
			</div>
			<div id="item-related-search" class="col-lg-12 pt-3 row"></div>
		</div>
	</div>
<?php require_once("../../../partials/footer.php") ?>