<?php 
	$section = "profile";
	$pageTitle = "Profile";
?>

<?php require_once("../partials/header.php") ?>

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

<div class="container py-5">
		<section class="row justify-content-center">
			<div class="col-md-4">
				
				<label class="text-center text-success p-5"><?php echo changedp() ?></label>
				<?php 
					
				?>

				<div class="card px-4">
					
					<img src="<?php get_url() ?>/assets/images/profile.<?php echo get_extensionshit() ?>" alt="image" class="card-img-top">

					<div class="card-body px-0">
						<form action="<?php get_url() ?>/controllers/process.upload.php" enctype="multipart/form-data" method="POST">
							<div class="form-group <?php //custom-file ?> py-2">
								<label class="<?php //custom-file-label ?>" for="image-upload">
									Choose File
								</label>
								<input type="file" class="<?php //custom-file-input ?>" id="image-upload" name="image-upload">
							</div>

							<button type="submit" name="submit" class="btn btn-block btn-success py-2"> Upload </button>

						</form>
					</div>

				</div>
			</div>
		</section>
</div>

<?php require_once("../partials/footer.php") ?>