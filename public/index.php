<?php

set_include_path(dirname(__DIR__));

/**
 * Get the composer dependencies
 */
require 'vendor/autoload.php';
require 'App/autoload.php';

use \App\App;

$app = App::getInstance();
$app->load();
