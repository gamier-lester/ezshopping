<?php 
	$section = "profile";
	$pageTitle = "Profile";
	$use_firebase = true;
?>

<?php 
	require_once("../../partials/header.php");
	if (!isset($_SESSION["user_credentials"])) {
		header("Location: ".ROOT_URL."/views/login.php");
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
		<section class="row justify-content-center py-5">
			<div class="col-lg-3">
				<div class="sticky-top">
				<?php
					$query = "SELECT id, media_link FROM ecom_user_media WHERE user_id = $user_id AND type_id = 1 AND status_id = 1 LIMIT 1";
					$result = $conn->query($query);
					if ($result->num_rows > 0) :
						while($imageRow = $result->fetch_assoc()){
				?>
					<div class="image-overlay-container">
					  <img id="display_picture" src="<?php echo $imageRow['media_link'] ?>" alt="Avatar" class="image-overlay-image">
					  <div class="image-overlay-middle">
					    <div class="image-overlay-text"><label for="hidden_profile_input" onclick="toggleSubmitButton('button#hidden-submit')">Change Image</label></div>
					  </div>
					  <form action="<?php get_url() ?>/controllers/process.upload.php" method="POST" class=".visibility-hidden">
					  	<input id="upload_media_link" type="text" name="media_link" hidden>
					    <input type="file" id="hidden_profile_input" accept="image/*" required onclick="uploadImage('change', this, '.display_picture')" hidden>
					  </form>
					  <button id="hidden-submit" class="btn btn-block btn-success display-none mt-2" onclick="uploadImage('submit', this, 'upload_media_link')">Upload Image</button>
					</div>
				<?php } ?>
				<?php else: ?>
					<form action="<?php get_url() ?>/controllers/process.upload.php" method="POST">
					  <div class="custom-file">
					  	<input id="upload_media_link" type="text" name="media_link" hidden>
					    <input type="file" class="custom-file-input" id="validatedCustomFile" accept="image/*" required onclick="uploadImage('change', this)">
					    <label class="custom-file-label" for="validatedCustomFile" onclick="uploadImage('change', this)">Choose file...</label>
					  </div>
					</form>
					<button class="btn btn-block btn-success" onclick="uploadImage('submit', this, 'upload_media_link')">Upload Image</button>
				<?php endif; ?>
					<form class="py-3" action="<?php get_url() ?>/controllers/process.profile-update.php" method="POST">
						<input type="number" name="user_id" value="<?php echo $user_id; ?>" hidden>
						<div class="input-group mb-1">
						  <div class="input-group-prepend">
						    <span class="input-group-text">@</span>
						  </div>
						  <input type="text" class="form-control text-center" placeholder="username" disabled value="<?php echo $_SESSION["user_credentials"]["user_username"] ?>">
						</div>
						<div class="form-group row">
						  <label for="form_email" class="col-sm-5 col-form-label">Email</label>
						  <div class="col-sm-7">
						  	<input id="form_email" type="text" class="form-control text-center" name="email" placeholder="email" value="<?php echo isset($user_details)? $user_details['user_email'] : $user_default ?>">
						  </div>
						</div>
						<div class="form-group row">
						  <label for="form_firstname" class="col-sm-5 col-form-label">First Name</label>
						  <div class="col-sm-7">
						  	<input id="form_firstname" type="text" class="form-control text-center" name="firstname" placeholder="firstname" value="<?php echo isset($user_details)? $user_details['user_firstname'] : $user_default ?>">
						  </div>
						</div>
						<div class="form-group row">
						  <label for="form_lastname" class="col-sm-5 col-form-label">Last Name</label>
						  <div class="col-sm-7">
						  	<input id="form_lastname" type="text" class="form-control text-center" name="lastname" placeholder="lastname" value="<?php echo isset($user_details)? $user_details['user_lastname'] : $user_default ?>">
						  </div>
						</div>
						<button type="submit" class="btn btn-success btn-block">Update</button>
					</form>
					<div class="list-group">
					  <a href="?view=item" class="list-group-item list-group-item-action <?php echo isset($_GET['view']) ? $_GET['view'] === 'item' ? 'active' : '' : 'active' ;?>">My Items</a>
					  <a href="?view=message" class="list-group-item list-group-item-action <?php echo isset($_GET['view']) ? $_GET['view'] === 'message' ? 'active' : '' : '' ;?>">My Messages</a>
					</div>
				</div>
			</div>
			<?php if(!isset($_GET['view']) || (isset($_GET['view'])) && $_GET['view'] === 'item'): ?>
			<div class="col-lg-8">
				<?php if (isset($_SESSION['response_message'])): ?>
				<div class="alert alert-<?php echo $_SESSION['response_message']['success'] ? 'success' : 'danger'; ?> alert-dismissible fade show text-center" role="alert">
				  <?php echo $_SESSION['response_message']['message']; ?>
				  <button type="button" class="close" data-dismiss="alert">
				    <span>&times;</span>
				  </button>
				</div>
				<?php unset($_SESSION['response_message']); ?>
				<?php endif; ?>
				<button class="btn btn-primary mb-3 btn-block" type="button" data-toggle="collapse" data-target="#add_new_item">
			    Add item!
			  </button>
			  <?php if (isset($_SESSION['response_message'])): ?>
			  <div class="alert alert-<?php echo $_SESSION['response_message']['success'] ? 'success' : 'danger'; ?> alert-dismissible fade show text-center my-2" role="alert">
				  <?php echo $_SESSION['response_message']['message']; ?>
				  <button type="button" class="close" data-dismiss="alert">
				    <span>&times;</span>
				  </button>
				</div>
				<?php unset($_SESSION['response_message']); endif; ?>
			  <div class="collapse mb-3" id="add_new_item">
				  <div class="card card-body">
				    <!-- <form></form> -->
				    <div class="row">
				    	<div class="col-lg-6">
				    		<div class="image-overlay-container">
								  <img id="new_item_display_picture" src="<?php echo DEFAULTDP; ?>" alt="Avatar" class="image-overlay-image">
								  <div class="image-overlay-middle">
								    <div class="image-overlay-text"><label for="form_item_container_media_primary">Upload Item Photo</label></div>
								  </div>
								</div>
				    	</div>
				    	<div class="col-lg-6">
				    		<form id="add_new_item_form" action="<?php get_url(); ?>/controllers/process.add-item.php" method="POST">
				    			<div class="form-group row">
									  <label for="form_item_name" class="col-sm-4 col-form-label">Item Name</label>
									  <div class="col-sm-8">
									  	<input id="form_item_name" type="text" class="form-control text-center" name="form_item_name" placeholder="Item name...">
									  </div>
									</div>
				    			<div class="form-group row">
									  <label for="form_item_description" class="col-sm-4 col-form-label">Description</label>
									  <div class="col-sm-8">
									  	<textarea class="form-control" id="form_item_description" rows="3" name="form_item_description" placeholder="Describe your item here..."></textarea>
									  </div>
									</div>
				    			<div class="form-group row">
									  <label for="form_item_price" class="col-sm-4 col-form-label">Price</label>
									  <div class="col-sm-8">
									  	<input id="form_item_price" type="number" class="form-control text-center" name="form_item_price" placeholder="1">
									  </div>
									</div>
									<div class="form-group">
										<input id="form_item_user_id" type="text" name="form_item_user_id" value="<?php echo $user_id; ?>" hidden>
										<input id="form_item_media_primary" type="text" name="form_item_media_primary" hidden>
										<input id="form_item_media_secondary" type="text" name="form_item_media_secondary" hidden>
										<input id="form_item_container_media_primary" class="form-control" type="file" name="form_item_container_media_primary" accept="image/*" onchange="changePrimaryImage('#new_item_display_picture',event)" hidden>
										<input id="form_item_container_media_secondary" class="form-control" type="file" name="form_item_container_media_secondary" accept="image/*" multiple hidden>
									</div>
				    		</form>
				    		<button class="btn btn-block btn-success" onclick="addNewItem(this)">Save Item</button>
				    	</div>
				    </div>
				  </div>
				</div>
				<?php
					$query = "SELECT itemRow.id as item_id, itemRow.name as item_name, itemRow.description as item_description, itemRow.price as item_price, mediaRow.media_link FROM ecom_item_basics itemRow JOIN ecom_item_media mediaRow ON itemRow.id = mediaRow.item_id && mediaRow.type_id = 1 WHERE itemRow.user_id = $user_id";
					$result = $conn->query($query);
					while ($itemRow = $result->fetch_assoc()) {
				?>
			  <div class="card card-body mb-3">
			    <!-- <form></form> -->
			    <div class="row">
			    	<div class="col-lg-6">
			    		<div class="image-overlay-container">
							  <img id="new_item_display_picture" src="<?php echo $itemRow['media_link']; ?>" alt="Avatar" class="image-overlay-image">
							  <div class="image-overlay-middle">
							    <div class="image-overlay-text"><label>Update Item Photo</label></div>
							  </div>
							</div>
			    	</div>
			    	<div class="col-lg-6">
			    		<form id="add_new_item_form" action="<?php get_url(); ?>/controllers/process.update-item.php" method="POST">
			    			<div class="form-group row">
								  <label for="form_item_name_<?php echo $itemRow['item_id']; ?>" class="col-sm-4 col-form-label">Item Name</label>
								  <div class="col-sm-8">
								  	<input id="form_item_name_<?php echo $itemRow['item_id']; ?>" type="text" class="form-control text-center" name="form_item_name" value="<?php echo $itemRow['item_name']; ?>">
								  </div>
								</div>
			    			<div class="form-group row">
								  <label for="form_item_description_<?php echo $itemRow['item_id']; ?>" class="col-sm-4 col-form-label">Description</label>
								  <div class="col-sm-8">
								  	<textarea class="form-control" id="form_item_description_<?php echo $itemRow['item_id']; ?>" rows="3" name="form_item_description"><?php echo $itemRow['item_description']; ?></textarea>
								  </div>
								</div>
			    			<div class="form-group row">
								  <label for="form_item_price_<?php echo $itemRow['item_id']; ?>" class="col-sm-4 col-form-label">Price</label>
								  <div class="col-sm-8">
								  	<input id="form_item_price_<?php echo $itemRow['item_id']; ?>" type="number" class="form-control text-center" name="form_item_price" value="<?php echo $itemRow['item_price']; ?>">
								  </div>
								</div>
								<div class="form-group">
									<input id="form_item_user_id" type="text" name="form_item_user_id" value="<?php echo $user_id; ?>" hidden>
									<input id="form_item_media_primary" type="text" name="form_item_media_primary" hidden>
									<input id="form_item_media_secondary" type="text" name="form_item_media_secondary" hidden>
									<input id="form_item_container_media_primary" class="form-control" type="file" name="form_item_container_media_primary" accept="image/*" onchange="changePrimaryImage('#new_item_display_picture',event)" hidden>
								</div>
			    		</form>
			    		<button class="btn btn-block btn-success" onclick="addNewItem(this)">Update Item</button>
			    	</div>
			    </div>
			  </div>
				<?php } ?>
			</div>
			<?php elseif (isset($_GET['view']) && $_GET['view'] === 'message'): ?>
			<div class="col-lg-8 row">

				<div class="col-lg-12">
					<div class="accordion" id="messageAccordion">
					  <div class="card">
					    <div class="card-header" id="headingOne">
					      <h2 class="mb-0">
					        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#new_message">
					          Send New Message
					        </button>
					      </h2>
					    </div>

					    <div id="new_message" class="collapse show" data-parent="#messageAccordion">
					      <div class="card-body">
					        <form>
				        	<?php
										$contacts_array = array();
										$query = "SELECT userRow.user_id, userRow.user_firstname FROM ecom_message_details message JOIN ecom_user_details userRow ON message.receiver_id = userRow.user_id WHERE message.sender_id = $user_id";
										$result = $conn->query($query);
										if ($result->num_rows > 0):
											while ($row = $result->fetch_assoc()) {
												$contacts_array[$row['user_id']] = $row['user_firstname'];
											}
									?>
									  <div class="form-group">
									    <label for="contact_list">Recipient</label>
									    <select class="form-control" id="contact_list" name="receiver_id">
									    	<?php foreach($contacts_array as $key => $value) { ?>
									      <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
									    	<?php } ?>
									    </select>
									  </div>
								  <?php else: ?>
								  	<div class="form-group">
								  		<label for="receiver_id">Recipient email: </label>
								  		<input id="receiver_id" class="form-control" type="text" name="receiver_id">
								  	</div>
								  <?php endif; ?>
									  <div class="form-group">
									    <label for="message_content">Message</label>
									    <textarea class="form-control" id="message_content" name="message_content" placeholder="Your message here..." rows="3" required></textarea>
									    <input type="text" name="sender_id" value="<?php echo $user_id; ?>" hidden>
									  </div>
									  <div class="form-group">
									  	<button type="submit" class="btn btn-block btn-success">Send Message!</button>
									  </div>
									</form>
					      </div>
					    </div>
					  </div>
					  <?php
					  	$query = "SELECT mcontent.message_content, mdetails.id as message_id, mdetails.sender_id, mdetails.receiver_id, mdetails.date_created as message_date,sdetails.user_email as sender_email, rdetails.user_email as receiver_email, status_details.status_name FROM ecom_message_details mdetails JOIN ecom_message_content mcontent ON mdetails.id = mcontent.message_id JOIN ecom_user_details sdetails ON mdetails.sender_id = sdetails.user_id JOIN ecom_user_details rdetails ON mdetails.receiver_id = rdetails.user_id JOIN ecom_status status_details ON mdetails.status_id = status_details.id WHERE mdetails.sender_id = $user_id OR mdetails.receiver_id = $user_id ORDER BY mdetails.id DESC LIMIT 5";
					  	$result = $conn->query($query);
					  	if ($result->num_rows !== 0):
					  		while ($messageRow = $result->fetch_assoc()) {
					  ?>
					  <div class="card">
					    <div class="card-header" id="headingTwo">
					      <h2 class="mb-0">
					        <button id="messageButton-<?php echo $messageRow['message_id']; ?>" class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#message-<?php echo $messageRow['message_id']; ?>" onclick="readMessage(<?php echo $messageRow['message_id'].','.'\'messageButton-'.$messageRow['message_id'].'\''; ?>)">
					          <?php echo ($messageRow['sender_id'] === $user_id) ? "Your message to @".$messageRow['receiver_email'] : "You received a message from @".$messageRow['sender_email']; ?>
					          <?php echo $messageRow['receiver_id'] === $user_id && $messageRow['status_name'] === 'new_message' ? "<span class=\"badge badge-success\">New Message</span>" : ''; ?>
					        </button>
					      </h2>
					    </div>
					    <div id="message-<?php echo $messageRow['message_id']; ?>" class="collapse" data-parent="#messageAccordion">
					      <div class="card-body">
					        <p class="text-right">Message <i><?php echo $messageRow['sender_id'] === $user_id ? "sent @".$messageRow['message_date'] : "received @".$messageRow['message_date']; ?></i></p>
					        <p class="lead">Message...</p>
					        <p class="lead">&emsp;&emsp;<?php echo $messageRow['message_content']; ?></p>
					      </div>
					    </div>
					  </div>
					  <?php } endif; ?>
					</div>
				</div>
			</div>
			<?php endif; ?>
		</section>
</div>

<?php // echo $_SERVER['HTTP_HOST']; echo ' '; echo $_SERVER['REQUEST_URI']; ?>
<?php $conn->close(); ?>
<?php require_once("../../partials/footer.php") ?>