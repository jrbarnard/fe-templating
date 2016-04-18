<?php
/**
 * Autoload dependencies and Application
 */
require dirname(__DIR__) . '/vendor/autoload.php';

use \App\App;

$app = App::getInstance();
$app->load();
