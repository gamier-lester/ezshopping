<?php 
	$pageTitle = "Send Message";
	$section = "login";
?>

<?php 
	require_once("../../partials/header.php");
	
	if (!isset($_SESSION["user_credentials"])) {
		$_SESSION['error_message'] = 'You need to login first!';
		header("Location: ".ROOT_URL."/views/login.php");
	}

	$user_id = $_SESSION['user_credentials']['user_id'];
	$conn = new mysqli(DBSERVERNAME, DBUSERNAME, DBPASSWORD, DBNAME);

	if ($conn->connect_error) {
		die("Connection failed: ".$conn->connect_error);
	}
?>

<div class="container py-5">
	<section class="row justify-content-center">

		<div class="col-md-6">
			<h2> Send Message 🧛 </h2>
			<?php if (isset($_SESSION['response_message'])): ?>
			<div class="alert alert-<?php echo $_SESSION['response_message']['success'] ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
			 	<?php echo $_SESSION['response_message']['message']; ?>
			  <button type="button" class="close" data-dismiss="alert">
			    <span>&times;</span>
			  </button>
			</div>
			<?php unset($_SESSION['response_message']); endif; ?>
			<form action="<?php get_url() ?>/controllers/process.send-message.php" method="POST">
				<div class="form-group">
					<label for="receiver_name"> Recipient </label>
					<?php if (isset($_GET['messageto'])): ?>
					<?php
						$receiver_id = $_GET['messageto'];
						$query = "SELECT users.user_id, users.user_firstname FROM ecom_user_details users WHERE users.user_id = $receiver_id";
						$result = $conn->query($query);
						while ($user_row = $result->fetch_assoc()) {
					?>
					<input id="receiver_id" type="text" name="receiver_id" class="form-control" value="<?php echo $receiver_id; ?>" hidden>
					<input id="receiver_name" type="text" name="receiver_name" class="form-control" value="<?php echo $user_row['user_firstname']; ?>" disabled>
					<?php } ?>
					<?php elseif (!isset($_GET['messageto'])): ?>
					<input id="receiver_name" type="text" name="receiver_name" class="form-control" value="" disabled>
					<?php endif; ?>
					<input id="sender_id" type="text" name="sender_id" class="form-control" value="<?php echo $user_id; ?>" hidden>
				</div>
				<div class="form-group">
					<label for="message_content"> Message </label>
					<textarea class="form-control" id="message_content" rows="3" name="message_content" placeholder="Your message here..."></textarea>
				</div>
				<button type="submit" class="btn btn-success btn-block"> Submit </button>
			</form>

		</div>

	</section>
</div>

<?php require_once("../../partials/footer.php") ?>