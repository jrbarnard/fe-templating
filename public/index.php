<?php
/**
 * This is the entry point for the framework
 * Do not edit below.
 * See ../readme.md for documentation
 */

/**
 * Autoload dependencies and Application
 */
require dirname(__DIR__) . '/vendor/autoload.php';

use \Proto\App;

$app = App::getInstance();
$app->load();
