<?php
$tempPath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;
set_include_path($tempPath);

define('RRDEVELOPMENT', true);
define('RRASSETS', '/assets/');
define('RRJS', RRASSETS . 'js/');
define('RRCSS', RRASSETS . 'css/');
define('RRIMG', RRASSETS . 'images/');
include "parts/doctype.php";
?>
<head>

	<title><?php echo $tp->title; ?> | Test FE Templating</title>
	<script>
		//for removing no-js class
		document.getElementsByTagName("html")[0].className = document.getElementsByTagName("html")[0].className.replace( 'no-js' , 'js' );
	</script>
	<meta name="description" content="_______________" />
	<?php 
		include "parts/meta.php";
		include "parts/css.php";
	?>
</head>
<body>
	<?php include "parts/ga.php"; // include google analytics ?>
	
	<?php
	include "parts/header.php"; // include header
	include 'parts/breadcrumbs.php'; // include breadcrumbs

	// if the content file exists then include
	if ($tp->content_exists()) {
		include $tp->contentpath;
	} else {
		echo $tp->content . ' content partial does not exist';
	}

	// if the template exists then include, else say partial does not exist
	if ($tp->template_exists()) {
		include $tp->template . '.php';
	} else {
		echo $tp->template . ' template partial does not exists';
	}

	include "parts/footer.php"; // include footer
	?>
	
	<?php include "parts/scripts.php"; // include javascript ?>
</body>
</html>