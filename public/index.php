<?php

set_include_path(dirname(__DIR__));

/**
 * Autoload dependencies and Application
 */
require 'vendor/autoload.php';

use \App\App;

$app = App::getInstance();
$app->load();
