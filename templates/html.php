<?php
$GLOBALS['tempPath'] = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;

// Specify these to whatever your assets structure is, allows you to access images etc by echoing out the constant RRIMG then the relative path
define('RRASSETS', '/assets/');
define('RRJS', RRASSETS . 'js/');
define('RRCSS', RRASSETS . 'css/');
define('RRIMG', RRASSETS . 'images/');
?>

<!DOCTYPE html>
<!--[if lt IE 9]>    <html class="no-js ie lt-ie9 lt-ie10 <?php if (RRDEVELOPMENT): echo 'rr_development'; endif; ?>" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie ie9 lt-ie10 <?php if (RRDEVELOPMENT): echo 'rr_development'; endif; ?>" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="goodie no-js <?php if (RRDEVELOPMENT): echo 'rr_development'; endif; ?>" lang="en"> <!--<![endif]-->
<head>

	<title><?php echo $tp->title; ?></title>
	<script>
		//for removing no-js class
		document.getElementsByTagName("html")[0].className = document.getElementsByTagName("html")[0].className.replace( 'no-js' , 'js' );
	</script>
	<meta name="description" content="_______________" />
	
	<?php include "parts/meta.php"; ?>
	
</head>
<body>
	<?php

	include "parts/header.php"; // include header
	include 'parts/breadcrumbs.php'; // include breadcrumbs

	// Initiate twig
	$tp->twig_init();

	include "parts/footer.php"; // include footer
	include "parts/scripts.php"; // include javascript ?>
</body>
</html>