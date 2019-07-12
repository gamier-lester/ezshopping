<?php 
	$pageTitle = "Home";
	$section = "home";
	require_once("../partials/header.php");
	if (isset($_GET["off"]) && isset($_GET["lim"])) {
		$offset = $_GET["off"];
		$limit = $_GET["lim"];
	} elseif (!isset($_GET["off"]) && !isset($_GET["lim"])) {
		$offset = 0;
		$limit = 9;
	}
?>

<?php
	$conn = new mysqli(DBSERVERNAME, DBUSERNAME, DBPASSWORD, DBNAME);
	if ($conn->connect_error) {
		die("Connection failed: ".$conn->connect_error);
	}
?>
	<div class="container py-5">
		<div class="row justify-content-center">
			<div class="col-lg-3">
				<p class="lead">sample nav</p>
			</div>
			<div class="col-lg-9">
				<div class="row justify-content-around">
					<?php
						$query = "SELECT * FROM ecom_item_basics LIMIT $limit OFFSET $offset";
						$result = $conn->query($query);
						if ($result->num_rows > 0):
					?>
					<?php while ($row = $result->fetch_assoc()) { ?>
					<div class="card col-lg-4 mb-2 mx-1">
					  <div class="card-body">
					    <h5 class="card-title"><?php echo $row["name"] ?></h5>
					    <h6 class="card-subtitle mb-2 text-muted"><?php echo $row["price"] ?></h6>
					    <p class="card-text"><?php echo $row["description"] ?></p>
					    <a href="#" class="card-link">Visit Seller</a>
					    <a href="#" class="card-link">Add to Cart</a>
					  </div>
					</div>
					<?php } ?>
					<?php else: ?>
					<div class="col-lg-12">
						<p class="lead">Nothing to display</p>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

<?php $conn->close(); ?>
<?php require_once("../partials/footer.php") ?>