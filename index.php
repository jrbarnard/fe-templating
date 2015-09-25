<?php
//get the structure file and pass to class
require "template-class.php";
require "structure.php";

$tp = new Template($structure);

require "templates/html.php";
