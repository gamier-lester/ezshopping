<?php 
	$pageTitle = 'Shopping - Home';
	$page_css = '/views/shopping/home/home.css';
	$page_js = '/views/shopping/home/home.js';
	require_once("../../../partials/header.php");
?>

	<div class="container py-5">
		<div class="row justify-content-center">
			<div class="col-lg-3">
				<div class="sticky-top z-index-1">
					<p class="lead">Sort Items</p>
					<div class="list-group">
						<button class="list-group-item list-group-item-action sort-buttons active" onclick="sortItems('ASC', this)">Lowest Price</button>
						<button class="list-group-item list-group-item-action sort-buttons" onclick="sortItems('DESC', this);">Highest Price</button>
					</div>
				</div>
			</div>
			<div class="col-lg-9">
				<div id="item-container" class="row justify-content-around">
					<div class="col-lg-12">
						<p class="lead">Nothing to display</p>
					</div>
				</div>
			</div>
			<div id="page-pagination" class="col-lg-10">
				<nav><ul class="pagination justify-content-end"></ul></nav>
			</div>
		</div>
	</div>

<?php require_once("../../../partials/footer.php") ?>