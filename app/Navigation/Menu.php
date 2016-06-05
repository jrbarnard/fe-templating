<?php
namespace App\Navigation;
/**
 * Class Menu
 * @package App\Navigation
 */
class Menu
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
     * @var null
     */
    protected $levelsToGo = null;

    /**
     * A flag so we can notify up a recursion method that children are active
     * @var bool
     */
    protected $activeFlag = false;

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
     * Method that takes the routes and builds the menu item array up
     * @param $routes
     * @param int $level
     * @param string $parentUri
     * @return array
     */
    protected function build($routes, $level = 0, $parentUri = '')
    {
        $menuItems = array();
        foreach($routes as $uri => $route) {

            // generate the current uri of the MenuItem
            if ($level === 0) {
                $currentUri = '';
            }
            $currentUri = mb_strpos($uri, '/') === 0 ? $uri : $parentUri . '/' . $uri;

            // generate title
            // will prioritise link title if available
            $title = '';
            if (isset($route['link-title'])) {
                $title = $route['link-title'];
            } else if (isset($route['title'])) {
                $title = $route['title'];
            }

            // initialise menu item and set basic data
            $menuItem = MenuItem::init($currentUri, $title)
                ->setLevel($level);

            // set hidden if necessary
            if ($this->honorHidden && isset($route['hidden']) && $route['hidden'] === true) {
                $menuItem->setHidden();
            }

            // does the route have children, if so, get recursively
            if (isset($route['children']) && !empty($route['children'])) {
                $level++; // set the level up one

                // only get children if we haven't restricted recursion or we haven't hit the limit yet
                if (is_nan($this->levelsToGo) || $level < $this->levelsToGo) {
                    // pass the route children back into this method to get recursively and store in menuItem
                    $menuItem->setChildren(
                        $this->build(
                            $route['children'],
                            $level,
                            $currentUri
                        )
                    );


                }

                // did one of the children set the active flag?
                if ($this->activeFlag) {
                    $menuItem->setActive();
                    $this->activeFlag = false;
                }

                $level--; // bring level back down
            }

            if ($uri === $this->currentUri) {
                // this is the current menu item, we need to set it to current
                // then set a flag to set up the tree to active
                $menuItem->setCurrent()
                    ->setActive();

                $this->activeFlag = true;
            }

            // set the menu item into the array
            $menuItems[] = $menuItem;
        }

        return $menuItems;
    }

    /**
     * Return menu as array
     * @return array
     */
    public function toArray()
    {
        return $this->menuItems;
    }

    /**
     * Method to set the number of levels we should recursively go through when generating the menu
     * @param null $levels
     * @return $this
     */
    public function setLevelsToIterate($levels = null)
    {
        if (!is_numeric($levels)) {
            $levels = null;
        }
        $this->levelsToGo = $levels;
        return $this;
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