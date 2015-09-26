<?php
define('APPDIR', $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR);
//get the structure file and pass to class
require APPDIR . "template-class.php";
require APPDIR . "structure.php";

$tp = new Template($structure);

require "templates/html.php";
