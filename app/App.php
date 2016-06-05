<?php

namespace App;

use App\Navigation\Navigation;
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
     * @return App
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
        /**
         * Initialise the structure and store the object
         */
        $structure = Structure::init();

        /**
         * Take the current page Object the structure built for us and build the template for it
         */
        $template = Template::build($structure->current_page);

        /**
         * Run some global template set up
         */
        $template->twig->addGlobal('app', $_ENV);

        /**
         * Load navigation functions into twig
         * This allows us to easily generate different menus in twig
         */
        $navigation = new Navigation($structure);
        $template->twig->loadTwigFunctions(array(
            'getMenu' => array($navigation, 'getMenu'),
            'getBreadcrumbs' => array($navigation, 'getBreadcrumbs'),
            'getParentMenu' => array($navigation, 'getParentMenu'),
            'getSitemap' => array($navigation, 'getSitemap')
        ));

        /**
         * render the template
         */
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