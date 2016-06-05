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
     * A flag so we can notify up a recursion method that children are active
     * @var bool
     */
    protected $activeFlag = false;

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
        $this->menuItems = $this->build($routes);
    }

    /**
     * Method that takes the routes and builds the menu item array up
     * @param $routes
     * @param bool $honorHidden
     * @param int $level
     * @param string $currentUri
     * @return array
     */
    protected function build($routes, $honorHidden = true, $level = 0, $parentUri = '')
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
            if ($honorHidden && isset($route['hidden']) && $route['hidden'] === true) {
                $menuItem->setHidden();
            }

            // does the route have children, if so, get recursively
            if (isset($route['children']) && !empty($route['children'])) {
                $level++; // set the level up one

                // pass the route children back into this method to get recursively and store in menuItem
                $menuItem->setChildren(
                    $this->build(
                        $route['children'],
                        $honorHidden,
                        $level,
                        $currentUri
                    )
                );

                // TODO: SET PARENT TO ACTIVE IF ANY CHILDREN ARE ACTIVE ... LOOK INTO BASE PLUGIN

                $level--; // bring level back down

                if ($this->activeFlag) {
                    $menuItem->setActive();
                    $this->activeFlag = true;
                }
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
}