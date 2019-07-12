<?php require_once(realpath(__DIR__."/../config/path.php")) ?>
<!DOCTYPE html>
<html>
<head>
	<title> <?php echo $pageTitle ?> </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/png" href="<?php get_url() ?>/assets/images/sandbox.png"/>
	<!-- Bootstrap CSS -->
	<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->
	<link rel="stylesheet" type="text/css" href="<?php get_url() ?>/assets/bootstrap/bootstrap.min.css">
	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="<?php get_url() ?>/assets/css/style.css">
</head>
<body>

	<!-- Start Header -->
	<header>
		<!-- Start Nav -->
		<?php require_once("navbar.php") ?>
		<!-- End Nav -->
	</header>
	<!-- End Header -->

	<!-- Start Main -->
	<main id="main">