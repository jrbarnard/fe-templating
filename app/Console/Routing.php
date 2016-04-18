<?php
/**
 * This files purpose is to allow us to rewrite rules with the built in php web server
 */
if (preg_match('/\.(?:png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"])) {
    return false;
} else {
    $_GET['p'] = $_SERVER["REQUEST_URI"];
    include dirname(dirname(__DIR__)) . '/public/index.php';
}