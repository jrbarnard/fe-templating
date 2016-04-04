<?php

set_include_path(dirname(__DIR__));

/**
 * Get the composer dependencies
 */
require 'vendor/autoload.php';
require 'App/autoload.php';

$app = \App\App::getInstance();
$app->load();
