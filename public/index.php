<?php
/**
 * Get the composer dependencies
 */
require __DIR__ . '../vendor/autoload.php';
require __DIR__ . '../app/autoload.php';

$app = \App\Template::init();
$app->load();
