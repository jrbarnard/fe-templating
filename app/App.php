<?php

namespace App;

use Dotenv\Dotenv;
use Whoops;

/**
 * Class App
 * Singleton
 * Builds up the fundamental backbone of the app and calls it's child processes
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
        $template = Template::build($structure->current_page);

        $template->twig->addGlobal('routes', $structure->routes);
        $template->twig->addGlobal('app', array(
            'environment' => getenv('ENVIRONMENT')
        ));

        $template->render();
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
     * Method to get the application directory path
     * @return string
     */
    public static function getAppPath()
    {
        return __DIR__ . DIRECTORY_SEPARATOR;
    }

    /**
     * Method to get the cache directory path
     * @return string
     */
    public static function getCachePath()
    {
        return self::getAppPath() . 'cache' . DIRECTORY_SEPARATOR;
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