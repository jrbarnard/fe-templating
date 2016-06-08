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

/**
 * Helper to get cache path
 * @param string $path
 * @return string
 */
function cachePath($path = '')
{
    return applicationPath('cache' . ($path ? DIRECTORY_SEPARATOR . $path : ''));
}

/**
 * Helper to get application path
 * @param string $path
 * @return string
 */
function applicationPath($path = '')
{
    return dirname(__DIR__) . ($path ? DIRECTORY_SEPARATOR . $path : '');
}