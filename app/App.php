<?php

namespace App;

use Dotenv\Dotenv;
use Whoops;

/**
 * Class App
 * Singleton
 *
 * @package App
 */
class App
{
    /**
     * @var Singleton The reference to *Singleton* instance of this class
     */
    private static $instance;

    /**
     * Returns the *Singleton* instance of this class.
     *
     * @return Singleton The *Singleton* instance.
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
    protected function __construct()
    {
        self::registerExceptionHandler();
        self::initDotEnv();
    }

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    private function __wakeup()
    {
    }

    /**
     * Method for registering an exception handler
     */
    private static function registerExceptionHandler()
    {
        $whoops = new Whoops\Run;
        $whoops->pushHandler(new Whoops\Handler\PrettyPageHandler);
        $whoops->register();
    }

    /**
     * Loads the application
     */
    public function load()
    {
        $structure = Structure::init();

        // build up template if not 404
        Template::build($structure->current_page);
    }

    /**
     * Gets the base path of the complete application
     * @return string
     */
    public static function getBasePath()
    {
        return dirname(__DIR__) . DIRECTORY_SEPARATOR;
    }

    /**
     * Method to initialise dotenv on base path
     */
    private static function initDotEnv()
    {
        $dotenv = new Dotenv(self::getBasePath());
        $dotenv->load();
    }
}