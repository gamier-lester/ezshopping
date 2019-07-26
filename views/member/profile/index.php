<?php 
	$pageTitle = 'Member - Profile';
	$page_css = '/views/member/profile/profile.css';
	$page_js = '/views/member/profile/profile.js';
	$use_firebase = true;
	require_once("../../../partials/header.php");
?>

<div class="container">
	<section class="row justify-content-center py-5">
		<div id="content-alert-container" class="col-lg-12"></div>
		<div class="col-lg-3">
			<div id="profile-container" class="sticky-top">
				<div id="profile-alert-container" class="col-lg-12"></div>
				<div id="profile-media-container" class="image-overlay-container"></div>
				<form>
			  	<input id="upload_media_link" type="text" name="media_link" hidden>
			    <input type="file" id="hidden_profile_input" accept="image/*" onchange="changeImage('hidden_profile_input', 'display_picture'); showSubmit('hidden-submit');" required hidden>
			  	<button id="hidden-submit" class="btn btn-block btn-success display-none mt-2" type="button" onclick="uploadImage('hidden_profile_input')">Upload Image</button>
			  </form>

			  <div id="profile-details-alert-container" class="col-lg-12"></div>
			  <form id="profile-details-container" class="py-3">
					<div class="input-group mb-1">
					  <div class="input-group-prepend">
					    <span class="input-group-text">@</span>
					  </div>
					  <input id="form_profile_username" type="text" class="form-control text-center" placeholder="username" disabled>
					</div>
					<div class="form-group row">
					  <label for="form_profile_email" class="col-sm-5 col-form-label">Email</label>
					  <div class="col-sm-7">
					  	<input id="form_profile_email" type="text" class="form-control text-center" name="email" placeholder="email">
					  </div>
					</div>
					<div class="form-group row">
					  <label for="form_profile_firstname" class="col-sm-5 col-form-label">First Name</label>
					  <div class="col-sm-7">
					  	<input id="form_profile_firstname" type="text" class="form-control text-center" name="firstname" placeholder="firstname">
					  </div>
					</div>
					<div class="form-group row">
					  <label for="form_profile_lastname" class="col-sm-5 col-form-label">Last Name</label>
					  <div class="col-sm-7">
					  	<input id="form_profile_lastname" type="text" class="form-control text-center" name="lastname" placeholder="lastname">
					  </div>
					</div>
					<button id="update-profile-button" type="button" class="btn btn-success btn-block" onclick="updateProfile('profile-details-container', this)">Update</button>
				</form>
				<div class="list-group">
				  <button type="button" class="list-group-item list-group-item-action profile-nav active cursor-pointer" data-toggle="collapse" data-target="#view_items" onclick="toggleNavActive(this)" disabled="true">My Items</button>
				</div>
			</div>
		</div>
		<div class="col-lg-8 collapse show" id="view_items">
			<button class="btn btn-primary mb-3 btn-block" type="button" data-toggle="collapse" data-target="#add_new_item">
		    Add item!
		  </button>

		  <div class="collapse mb-3" id="add_new_item">
			  <div class="card card-body">
			    <div class="row">
			    	<div class="col-lg-6">
			    		<div id="add-item-image" class="image-overlay-container" onmouseover="toggleFormAlert(this);">
							  <img id="new_item_display_picture" src="<?php echo DEFAULTDP; ?>" alt="Avatar" class="image-overlay-image">
							  <div class="image-overlay-middle">
							    <div class="image-overlay-text"><label for="form_item_container_media_primary">Upload Item Photo</label></div>
							  </div>
							</div>
			    	</div>
			    	<div class="col-lg-6">
			    		<form id="add_new_item_form">
			    			<div class="form-group row">
								  <label for="form_item_name" class="col-sm-4 col-form-label">Item Name</label>
								  <div class="col-sm-8">
								  	<input id="form_item_name" type="text" class="form-control text-center" name="form_item_name" placeholder="Item name..." onclick="toggleFormAlert(this);">
								  </div>
								</div>
			    			<div class="form-group row">
								  <label for="form_item_description" class="col-sm-4 col-form-label">Description</label>
								  <div class="col-sm-8">
								  	<textarea class="form-control" id="form_item_description" rows="3" name="form_item_description" placeholder="Describe your item here..." onclick="toggleFormAlert(this);"></textarea>
								  </div>
								</div>
			    			<div class="form-group row">
								  <label for="form_item_price" class="col-sm-4 col-form-label">Price</label>
								  <div class="col-sm-8">
								  	<input id="form_item_price" type="number" class="form-control text-center" name="form_item_price" placeholder="1" onclick="toggleFormAlert(this);">
								  </div>
								</div>
								<div class="form-group">
									<input id="form_item_container_media_primary" class="form-control" type="file" name="form_item_container_media_primary" accept="image/*" onchange="changeImage('form_item_container_media_primary','new_item_display_picture',)" hidden>
								</div>
			    		</form>
			    		<button id="add-item-button" type="button" class="btn btn-block btn-success" onclick="addItem('add_new_item_form')">Save Item</button>
			    	</div>
			    </div>
			  </div>
			</div>
		</div>

		

	</section>
</div>

<?php require_once("../../../partials/footer.php") ?>