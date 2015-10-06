<?php
$GLOBALS['tempPath'] = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;
// set_include_path($GLOBALS['tempPath']);

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
	<?php
	include "parts/ga.php"; // include google analytics 

	include "parts/header.php"; // include header
	include 'parts/breadcrumbs.php'; // include breadcrumbs

	// require twig
	require_once APPDIR . 'Twig/Autoloader.php';
	Twig_Autoloader::register();

	// store the location of the templates
	$loader = new Twig_Loader_Filesystem($GLOBALS['tempPath']);
	$twig = new Twig_Environment($loader); // create the environment
	$twig->display($tp->template . '.php', $tp->content); // display the template passing in the content
	

	include "parts/footer.php"; // include footer
	include "parts/scripts.php"; // include javascript ?>
</body>
</html>