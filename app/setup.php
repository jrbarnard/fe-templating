<?php

require "template-class.php";
require "structure.php";

// set to true to show errors and set other development vars
define('RRDEVELOPMENT', true);

if (RRDEVELOPMENT) {
	ini_set('display_errors', '1');
} else {
	ini_set('display_errors', '0');
}