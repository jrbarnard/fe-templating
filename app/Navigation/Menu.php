<?php
namespace App\Navigation;

/**
 * Abstract Class Menu
 * @package App\Navigation
 */
abstract class Menu
{
    /**
     * @var array
     */
    protected $menuItems = array();

    /**
     * @var string
     */
    protected $currentUri = '/';

    /**
     * @var bool
     */
    protected $honorHidden = true;

    /**
     * Storage for the raw routes before generating
     * @var array
     */
    protected $rawRoutes = array();

    /**
     * Menu constructor.
     * @param array $routes
     * @param string $currentUri
     * @throws \Exception
     */
    public function __construct($routes = array(), $currentUri = '/')
    {
        if (!is_array($routes)) {
            throw new \Exception('When building a menu, you must pass a valid array of routes');
        }
        $this->currentUri = $currentUri;
        $this->rawRoutes = $routes;
    }

    /**
     * @param array $routes
     * @param string $currentUri
     * @return static
     */
    public static function init($routes = array(), $currentUri = '/')
    {
        return new static($routes, $currentUri);
    }

    /**
     * Method to actually generate the menu
     */
    public function generate()
    {
        $this->menuItems = $this->build($this->rawRoutes);
        return $this;
    }

    /**
     * Method to build the navigation menu
     * Abstract so we can alter implementation
     * @param $routes
     * @return mixed
     */
    abstract protected function build($routes);

    /**
     * Return menu as array
     * @return array
     */
    public function toArray()
    {
        return $this->menuItems;
    }

    /**
     * Method to not honor hidden of routes passed in when generating menu
     * @return $this
     */
    public function doNotHonorHidden()
    {
        $this->honorHidden = false;
        return $this;
    }
}