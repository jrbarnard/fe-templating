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
     * @param $levelsToGo
     * @return array
     */
    public function getMenu($levelsToGo = null)
    {
        $menu = RecursiveMenu::init(
            $this->structure->routes,
            $this->structure->current_page->uri
        )->setLevelsToIterate($levelsToGo)->generate();
        return $menu->toArray();
    }

    /**
     * Method that generates the breadcrumbs based off your current location (within routes)
     * @return array
     */
    public function getBreadcrumbs()
    {
        $breadcrumbs = BreadcrumbMenu::init(
            $this->structure->pages,
            $this->structure->current_page->uri
        )->generate();
        return $breadcrumbs->toArray();
    }

    /**
     * Method that generates a menu using the parent of the current location (route), so you get sibling MenuItems
     * @param null $levelsToGo
     * @return array
     */
    public function getParentMenu($levelsToGo = null)
    {
        $menu = RecursiveMenu::init(
            $this->structure->pages[0]->page['children'],
            $this->structure->current_page->uri
        )
            ->setLevelsToIterate($levelsToGo)
            ->setStartingUri('/' . $this->structure->pages[0]->uri)
            ->generate();
        return $menu->toArray();
    }

    /**
     * Method that generates a menu of the entire set of routes, not honoring hidden, for sitemap purposes
     * If you want a sitemap that honors hidden, use getMenu
     * @return string
     */
    public function getSitemap()
    {
        $menu = RecursiveMenu::init(
            $this->structure->routes,
            $this->structure->current_page->uri
        )->doNotHonorHidden()->generate();
        return $menu->toArray();
    }
}