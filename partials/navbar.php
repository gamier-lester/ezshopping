<?php 
	$section = NULL;

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

	  <div class="collapse navbar-collapse" id="sandbox-navbar">
	    <ul class="navbar-nav mr-auto">
	      <li class="nav-item">
	        <a class="nav-link <?php setActive("notes") ?>" href="<?php get_url() ?>/views/notes.php?section=notes">📝 Notes</a>
	      </li>
	    </ul>
	  </div>
  </div>
</nav>