<?php 
	$section = "profile";
	$pageTitle = "Profile";
?>

<?php 
	require_once("../../partials/header.php");
	if (!isset($_SESSION["user_credentials"])) {
		header("Location: ".ROOT_URL."/views/login.php");
	}
?>

<?php
	function changedp() {
		if (isset($_SESSION["profile-pic"])){
			if ($_SESSION["profile-pic"] == 1) {
				// echo "Profile Change Success";
				$_SESSION["profile-pic"] = 0;
				return "Profile picture changed SUCCESSFULLY";
			}	
		}
	}

	function get_extensionshit () {
		$myArr = glob("../assets/images/profile.*"); 
		// print_r($myArr); 
		$myPath = pathinfo($myArr[0], PATHINFO_EXTENSION);
		// echo $myPath;
		return $myPath;
	}

?>

<?php
	$conn = new mysqli(DBSERVERNAME, DBUSERNAME, DBPASSWORD, DBNAME);

	if ($conn->connect_error) {
		die("Connection failed: ".$conn->connect_error);
	}
	$user_id = $_SESSION['user_credentials']['user_id'];
	$query = "SELECT user_firstname, user_lastname, user_email
 		FROM ecom_user_details WHERE user_id LIKE '$user_id'";
 	$result = $conn->query($query);

 	// var_dump($result);
 	if ($result->num_rows > 0) {
 		// print_r($result);
 		while ($row = $result->fetch_assoc()) {
 			$user_details = array(
 				"user_firstname" => $row["user_firstname"],
 				"user_lastname" => $row["user_lastname"],
 				"user_email" => $row["user_email"]
	 		);
		}
 	} else {
 		// echo "no results";
 		$user_default = 'unset';
 	}
?>

<?php //print_r($_SESSION["user_credentials"]); ?>
<?php //echo $_SESSION["user_credentials"]["user_username"]; ?>
<div class="container">
		<section class="row justify-content-center">
			<div class="col-lg-4">
							<?php print_r($_SESSION['user_credentials']); ?>
				
			</div>
			<div class="col-lg-8">
				<div class="row justify-content-center">
					<div class="col-lg-5">
						<form class="py-3" action="<?php get_url() ?>/controllers/process.profile-update.php" method="POST">
							<input type="number" name="user_id" value="<?php echo $user_id; ?>" hidden>
							<div class="input-group mb-1">
							  <div class="input-group-prepend">
							    <span class="input-group-text">@</span>
							  </div>
							  <input type="text" class="form-control text-center" placeholder="username" disabled value="<?php echo $_SESSION["user_credentials"]["user_username"] ?>">
							</div>
							<div class="input-group mb-1">
							  <div class="input-group-prepend">
							    <span class="input-group-text">Email</span>
							  </div>
							  <input type="text" class="form-control text-center" name="email" placeholder="email" value="<?php echo isset($user_details)? $user_details['user_email'] : $user_default ?>">
							</div>
							<div class="input-group mb-1">
							  <div class="input-group-prepend">
							    <span class="input-group-text">First name</span>
							  </div>
							  <input type="text" class="form-control text-center" name="firstname" placeholder="firstname" value="<?php echo isset($user_details)? $user_details['user_firstname'] : $user_default ?>">
							</div>
							<div class="input-group mb-1">
							  <div class="input-group-prepend">
							    <span class="input-group-text">Last name</span>
							  </div>
							  <input type="text" class="form-control text-center" name="lastname" placeholder="lastname" value="<?php echo isset($user_details)? $user_details['user_lastname'] : $user_default ?>">
							</div>
							<button type="submit" class="btn btn-success btn-block col-lg-5 ml-auto">Update</button>
						</form>
					</div>
				</div>
				
			</div>
		</section>
</div>


<?php $conn->close(); ?>
<?php require_once("../../partials/footer.php") ?>