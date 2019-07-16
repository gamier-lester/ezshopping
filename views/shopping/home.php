<?php 
	$pageTitle = "Home";
	$section = "home";
	require_once("../../partials/header.php");
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
		<?php
			$query = "SELECT i.name, i.price, i.description, m.media_link, u.user_firstname AS merchant_firstname, s.status_name AS item_status, t.type_name AS item_type FROM ecom_item_basics i JOIN ecom_item_media m ON i.id = m.item_id && m.type_id = 1 JOIN ecom_user_details u ON i.user_id = u.user_id JOIN ecom_status s ON i.status_id = s.id JOIN ecom_type t ON i.type_id = t.id ORDER BY i.price ASC";

			$result = $conn->query($query);
			// print_r($result);
			// echo 'hello';
			while ($row = $result->fetch_assoc()) {
				print_r($row);
				echo '<br>';
			}
		?>
		<div class="row justify-content-center">
			<div class="col-lg-3">
				<p class="lead">sample nav</p>
				<?php print_r($_SESSION['user_credentials']); ?>
			</div>
			<div class="col-lg-9">
				<div class="row justify-content-around">
					<?php if (isset($_SESSION['add-to-cart_success-message'])): ?>
						<div class="alert alert-success alert-dismissible fade show col-lg-12" role="alert">
						  <?php echo $_SESSION['add-to-cart_success-message']; ?>
						  <button type="button" class="close" data-dismiss="alert">
						  	<span>&times;</span>
						  </button>
						  <?php unset($_SESSION['add-to-cart_success-message']); ?>
						</div>
					<?php elseif (isset($_SESSION['add-to-cart_error-message'])): ?>
						<div class="alert alert-danger alert-dismissible fade show col-lg-12" role="alert">
						  <?php echo $_SESSION['add-to-cart_error-message']; ?>
						  <button type="button" class="close" data-dismiss="alert">
						  	<span>&times;</span>
						  </button>
						  <?php unset($_SESSION['add-to-cart_error-message']); ?>
						</div>
					<?php endif; ?>
					<?php
						// $query = "SELECT * FROM ecom_item_basics LIMIT $limit OFFSET $offset";
						$query = "SELECT i.id, i.name, i.price, i.description, m.media_link, u.user_firstname AS merchant_firstname, s.status_name AS item_status, t.type_name AS item_type FROM ecom_item_basics i JOIN ecom_item_media m ON i.id = m.item_id && m.type_id = 1 JOIN ecom_user_details u ON i.user_id = u.user_id JOIN ecom_status s ON i.status_id = s.id JOIN ecom_type t ON i.type_id = t.id";
						$result = $conn->query($query);
						if ($result->num_rows > 0):
					?>
					<?php while ($row = $result->fetch_assoc()) { ?>
					<div class="card col-lg-4 mb-2 mx-1" onclick="overlayContent(<?php echo $row["id"]; ?>)">
						<img src="<?php echo $row["media_link"]; ?>" class="card-img-top">
					  <div class="card-body">
					    <h5 class="card-title"><?php echo $row["name"] ?></h5>
					    <h6 class="card-subtitle mb-2 text-muted"><?php echo $row["price"] ?></h6>
					    <p class="card-text"><?php echo $row["description"] ?></p>
					    <a href="#" class="card-link">Visit Seller</a>
					    <a href="#" class="card-link">Add to Cart &times;</a>
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
<?php require_once("../../partials/footer.php") ?>