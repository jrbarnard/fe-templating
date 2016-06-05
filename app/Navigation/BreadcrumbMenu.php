<?php
namespace App\Navigation;

class BreadcrumbMenu extends Menu
{

    /**
     * Method to build the navigation menu
     * Abstract so we can alter implementation
     * @param $routes
     * @return mixed
     */
    protected function build($routes)
    {
        $pageUri = '';
        $menuItems = array();
        $routesCount = count($routes);
        $level = 0;
        foreach($routes as $route) {
            $pageUri = $pageUri . '/' . $route->uri;

            $menuItem = new MenuItem($pageUri, $route->page['title']);
            $menuItem->setLevel($level);

            // is last one in routes?
            if ($level >= $routesCount - 1) {
                $menuItem->setCurrent();
            }

            $menuItems[] = $menuItem;
            $level++;
        }
        return $menuItems;
    }
}