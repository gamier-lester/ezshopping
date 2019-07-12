<?php 
	// $section = NULL;

	if(isset($_GET["section"])) {
		if($_GET["section"] == "notes") {
			$section = "notes";
		}
	}

	function setActive($input_str) {
		global $section;
		if($section == $input_str) {
			echo "active";
		}
	}
 	
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
  	<a class="navbar-brand" href="<?php get_url() ?>/index.php"><img src="<?php get_url() ?>/assets/images/sandbox.png" width="30" height="30"> Sandbox</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sandbox-navbar" aria-controls="sandbox-navbar" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	  <?php if(isset($_SESSION["user_credentials"])): ?>
	  <div class="collapse navbar-collapse" id="sandbox-navbar">
	    <ul class="navbar-nav ml-auto">
	      <li class="nav-item">
	        <a class="nav-link <?php setActive("home") ?>" href="<?php get_url() ?>/views/home.php">📝 Home</a>
	      </li>
	      <li class="nav-item dropdown">
	      	<a class="nav-link dropdown-toggle <?php setActive("profile") ?>" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
          	<?php echo $_SESSION["user_credentials"]["user_username"]; ?>
	        </a>
	        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
	          <a class="dropdown-item" href="<?php get_url() ?>/views/profile.php">View Profile</a>
	          <a class="dropdown-item" href="<?php get_url() ?>/controllers/process.logout.php">Logout</a>
	          <!-- <div class="dropdown-divider"></div> -->
	        </div>
	      </li>
	    </ul>
	  </div>
	  <?php else: ?>
  	<div class="collapse navbar-collapse" id="sandbox-navbar">
	    <ul class="navbar-nav mr-auto">
	      <li class="nav-item">
	        <a class="nav-link <?php setActive("login") ?>" href="<?php get_url() ?>/views/login.php?section=login">📝 Login</a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link <?php setActive("register") ?>" href="<?php get_url() ?>/views/register.php?section=register">📝 Register</a>
	      </li>
	    </ul>
	  </div>
		<?php endif; ?>
  </div>
</nav>