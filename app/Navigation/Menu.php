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
        $this->build($routes);
    }

    /**
     * Method that takes the routes and builds the menu item array up
     * @param $routes
     * @param bool $honorHidden
     * @param int $level
     * @return array
     */
    protected function build($routes, $honorHidden = true, $level = 0)
    {
        $menuItems = array();
        foreach($routes as $uri => $route) {

            $menuItem = MenuItem::init($route)
                ->setLevel($level);

            if ($honorHidden && $route['hidden']) {
                $menuItem->setHidden();
            }

            if ($uri === $this->currentUri) {
                // this is the current menu item, we need to set it to current and active
                // then set all it's parents to active also
                $menuItem->setActive()
                    ->setCurrent();
            }

            // does the route have children?
            if (isset($route['children']) && !empty($route['children'])) {
                $level++; // set the level up one

                // set the children to the recursive return from build
                $menuItem->setChildren(
                    $this->build(
                        $route['children'],
                        $honorHidden,
                        $level
                    )
                );

                // TODO: SET PARENT TO ACTIVE IF ANY CHILDREN ARE ACTIVE ... LOOK INTO BASE PLUGIN

                $level--; // bring level back down
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