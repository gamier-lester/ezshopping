<?php 
	$section = "profile";
	$pageTitle = "My Orders";
	// Vitam Impendere Vero
?>

<?php 
	require_once("../../partials/header.php");
	if (!isset($_SESSION["user_credentials"])) {
		header("Location: ".ROOT_URL."/views/login.php");
	}
	$user_id = $_SESSION['user_credentials']['user_id'];
	$conn = new mysqli(DBSERVERNAME, DBUSERNAME, DBPASSWORD, DBNAME);

	if ($conn->connect_error) {
		die("Connection failed: ".$conn->connect_error);
	}
?>

	<div class="jumbotron jumbotron-fluid mt-2">
	  <h1 class="mx-5">Transaction Page</h1>
	  <p class="lead mx-5">Manage your orders and transactions here!</p>
	  <hr class="my-4 mx-5">
	  <p class="mx-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	  tempor incididunt ut labore et dolore magna aliqua.</p>
	  <nav class="nav nav-pills flex-column flex-sm-row mx-5">
		  <a class="flex-sm-fill text-sm-center nav-link active" href="#">New Transactions</a>
		  <a class="flex-sm-fill text-sm-center nav-link" href="#">Old Transactions</a>
		  <a class="flex-sm-fill text-sm-center nav-link" href="#">Pending Transactions</a>
		  <a class="flex-sm-fill text-sm-center nav-link" href="#">Closed Transactions</a>
		</nav>
	</div>

	<div class="container py-5">
		<section class="row">
			<div class="col">
				
			</div>
			<?php
				$query = "SELECT id, transaction_date, transaction_code FROM ecom_transaction WHERE user_id = $user_id ORDER BY id DESC";
				$result = $conn->query($query);
				while ($row = $result->fetch_assoc()) {
					$transaction_id = $row['id'];
			?>
			<div class="col-lg-12">
				<p>Transaction Date: <?php echo $row['transaction_date']; ?> Transaction Code: <?php echo $row['transaction_code']; ?></p>
				<?php
					$query = "SELECT mediaCol.media_link, itemCol.id as item_id, itemCol.name as item_name, orderCol.item_price as item_price, merchantCol.user_firstname as merchant_name, merchantCol.user_id as merchant_id,transactionCol.transaction_code, orderCol.item_quantity as order_quantity, orderCol.order_amount, orderCol.order_date as order_created, orderCol.order_update, statusCol.status_name as order_status FROM ecom_transaction transactionCol JOIN ecom_order orderCol ON transactionCol.id = orderCol.transaction_id JOIN ecom_item_basics itemCol ON orderCol.item_id = itemCol.id JOIN ecom_item_media mediaCol ON itemCol.id = mediaCol.item_id && mediaCol.type_id = 1 JOIN ecom_user_details merchantCol ON itemCol.user_id = merchantCol.user_id JOIN ecom_status statusCol ON orderCol.order_status = statusCol.id WHERE transactionCol.user_id = $user_id && transactionCol.id = $transaction_id";
					$orders = $conn->query($query);
					while ($orderRow = $orders->fetch_assoc()) {
						$query = "SELECT payment_amount FROM ecom_payment WHERE transaction_id = $transaction_id ORDER BY id DESC LIMIT 1";
						$payment = $conn->query($query);
						if ($payment->num_rows > 0) {
							while ($paymentRow = $payment->fetch_assoc()) {
								$paymentData = $paymentRow['payment_amount'];
							}
						} else {
							$paymentData = 0;
						}
				?>
				<div class="row">
					<div class="col-lg-3 my-3 text-center">
						<img class="img-fluid" src="<?php echo $orderRow['media_link']; ?>">
					</div>
					<div class="col-lg-2 position-relative-lesky">
				    <div class="list-group align-vertical-lesky" id="list-tab" role="tablist">
				      <a class="list-group-item list-group-item-action active" id="list-<?php echo $transaction_id . 'itemdetails' . $orderRow['item_id']; ?>-list" data-toggle="list" href="#list-<?php echo $transaction_id . 'itemdetails' . $orderRow['item_id']; ?>" role="tab">ITEM DETAILS</a>
				      <a class="list-group-item list-group-item-action" id="list-<?php echo $transaction_id . 'orderdetails' . $orderRow['item_id']; ?>-list" data-toggle="list" href="#list-<?php echo $transaction_id . 'orderdetails' . $orderRow['item_id']; ?>" role="tab">ORDER DETAILS</a>
				      <a class="list-group-item list-group-item-action" id="list-<?php echo $transaction_id . 'ordereklabu' . $orderRow['item_id']; ?>-list" data-toggle="list" href="#list-<?php echo $transaction_id . 'ordereklabu' . $orderRow['item_id']; ?>" role="tab">ORDER EKLABU</a>
				    </div>
				  </div>
				  <div class="col-7 position-relative-lesky">
				    <div class="tab-content align-vertical-lesky" id="nav-tabContent">
				      <div class="tab-pane fade show table-responsive active" id="list-<?php echo $transaction_id . 'itemdetails' . $orderRow['item_id']; ?>" role="tabpanel">
				      	<table class="table table-bordered table-dark">
								  <thead>
								    <tr>
								      <th scope="col">Item Name</th>
								      <th scope="col">Item Price</th>
								      <th scope="col">Merchant Name</th>
								    </tr>
								  </thead>
								  <tbody>
								    <tr>
								      <td><span class="align-middle"><?php echo $orderRow['item_name']; ?></span></td>
								      <td><?php echo $orderRow['item_price']; ?></td>
								      <td><a href="<?php echo get_url(); ?>/views/modals/messaging.php?messageto=<?php echo $orderRow['merchant_id']; ?>" class="btn">Message <?php echo $orderRow['merchant_name']; ?></a></td>
								    </tr>
								  </tbody>
								</table>
				      </div>
				      <div class="tab-pane fade table-responsive" id="list-<?php echo $transaction_id . 'orderdetails' . $orderRow['item_id']; ?>" role="tabpanel">
				      	<table class="table table-bordered table-dark">
								  <thead>
								    <tr>
								      <th scope="col">Transaction Code</th>
								      <th scope="col">Order Quantity</th>
								      <th scope="col">Total Price</th>
								    </tr>
								  </thead>
								  <tbody>
								    <tr>
								      <td><?php echo $orderRow['transaction_code']; ?></td>
								      <td><?php echo $orderRow['order_quantity']; ?></td>
								      <td><?php echo $orderRow['order_amount']; ?></td>
								    </tr>
								  </tbody>
								</table>
								<div class="col-lg-6 ml-auto row justify-content-around px-0 mx-0">
									<a href="#" class="btn col-lg-5">Update Order</a>
									<a href="#" class="btn btn-danger col-lg-5">Cancel Order</a>
								</div>
				      </div>
				      <div class="tab-pane fade table-responsive" id="list-<?php echo $transaction_id . 'ordereklabu' . $orderRow['item_id']; ?>" role="tabpanel">
				      	<table class="table table-bordered table-dark">
								  <thead>
								    <tr>
								      <th scope="col">Create</th>
								      <th scope="col">Update</th>
								      <th scope="col">Status</th>
								      <th scope="col">Total Payment</th>
								    </tr>
								  </thead>
								  <tbody>
								    <tr>
								      <td><?php echo $orderRow['order_created']; ?></td>
								      <td><?php echo $orderRow['order_update']; ?></td>
								      <td><?php echo $orderRow['order_status']; ?></td>
								      <td><?php echo $paymentData; ?></td>
								    </tr>
								  </tbody>
								</table>
				      </div>
				    </div>
				  </div>
				  <div class="col-lg-12">
				  	<hr class="mb-2">
				  </div>
				  <div class="col-lg-12">
				  	<a href="#" class="btn btn-success btn-block col-lg-6 ml-auto my-0 p-2">Proceed To Payment: ₱ <?php echo $orderRow['order_amount']; ?></a>
				  </div>
				  <div class="col-lg-12">
				  	<hr class="mt-2 mb-5">
				  </div>
				</div>
				<?php	} ?>
			</div>
			<?php } ?>
		</section>
	</div>

<?php $conn->close(); ?>
<?php require_once("../../partials/footer.php") ?>