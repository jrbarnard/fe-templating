<?php
namespace App\Navigation;
use App\Structure;

/**
 * Class Navigation
 * @package App\Navigation
 */
class Navigation
{
    /**
     * @var Structure
     */
    protected $structure;

    /**
     * Navigation constructor.
     * @param Structure $structure
     */
    public function __construct(Structure $structure)
    {
        $this->structure = $structure;
    }

    /**
     * Method that generates the full menu of the routes into an array of MenuItems
     * It honors the hidden vars
     * @return array
     */
    public function getFullMenu()
    {
        $menu = new Menu($this->structure->routes);
        return $menu->toArray();
    }

    /**
     * Method that generates the breadcrumbs based off your current location (within routes)
     * @return array
     */
    public function getBreadcrumbs()
    {
        return 'breadcrumbs';
    }

    /**
     * Method that generates a menu using the parent of the current location (route), so you get sibling MenuItems
     * @return array
     */
    public function getParentMenu()
    {
        return 'parentmenu';
    }

    /**
     * Method that generates a menu of the entire set of routes, not honoring hidden, for sitemap purposes
     * If you want a sitemap that honors hidden, use getFullMenu
     * @return string
     */
    public function getSitemap()
    {
        return 'sitemap';
    }
}