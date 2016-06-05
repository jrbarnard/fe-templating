<?php
namespace App\Navigation;

/**
 * Class MenuItem
 * @package App\Navigation
 */
class MenuItem
{
    /**
     * @var int
     */
    protected $level = 0;

    /**
     * @var bool
     */
    protected $hasChildren = false;

    /**
     * @var bool/int
     */
    protected $childrenCount = false;

    /**
     * @var array of MenuItems
     */
    protected $children = array();

    /**
     * @var bool
     */
    protected $hidden = false;

    /**
     * @var string
     */
    protected $uri = '';

    /**
     * @var bool
     */
    protected $active = false;

    /**
     * @var bool
     */
    protected $current = false;

    /**
     * MenuItem constructor.
     * @param $route
     */
    public function __construct($route)
    {

    }

    /**
     * @param $route
     * @return static
     */
    public static function init($route)
    {
        return new static($route);
    }

    /**
     * Method to set a MenuItems children and associated properties
     * @param $children
     * @return $this
     */
    public function setChildren($children)
    {
        $this->children = $children;
        $this->hasChildren = true;
        $this->childrenCount = count($children);

        return $this;
    }

    /**
     * Set the level of the menu item
     * @param $level
     * @return $this
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Method to set the hidden flag on the menu item
     * @return $this
     */
    public function setHidden()
    {
        $this->hidden = true;
        return $this;
    }

    /**
     * Method to set menu item as active (could be current but is within the hierarchy of active pages
     * @return $this
     */
    public function setActive()
    {
        $this->active = true;
        return $this;
    }

    /**
     * Method to set menu item as the currently on page
     * @return $this
     */
    public function setCurrent()
    {
        $this->current = true;
        return $this;
    }
}