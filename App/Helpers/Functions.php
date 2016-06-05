<?php
/**
 * Helper functions general
 */

/**
 * Helper function to die and dump
 * @param $var
 */
function dd($var) {
    d($var);
    die();
}

/**
 * Helper function to just dump
 * @param $var
 */
function d($var) {
    dump($var);
}