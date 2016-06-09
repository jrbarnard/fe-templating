<?php
namespace Proto\Navigation;

/**
 * Class MenuItem
 * @package Proto\Navigation
 */
class MenuItem
{
    /**
     * @var int
     */
    public $level = 0;

    /**
     * @var bool
     */
    public $hasChildren = false;

    /**
     * @var int
     */
    public $childrenCount = 0;

    /**
     * @var array of MenuItems
     */
    public $children = array();

    /**
     * @var bool
     */
    public $hidden = false;

    /**
     * @var string
     */
    public $uri = '';

    /**
     * @var bool
     */
    public $active = false;

    /**
     * @var bool
     */
    public $current = false;

    /**
     * @var string
     */
    public $title = '';


    /**
     * MenuItem constructor.
     * @param $uri
     * @param $title
     */
    public function __construct($uri, $title)
    {
        $this->title = $title;
        $this->uri = $uri;
    }

    /**
     * @param $uri
     * @param $title
     * @return static
     */
    public static function init($uri, $title)
    {
        return new static($uri, $title);
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