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
     * @var int
     */
    protected $childrenCount = 0;

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
     * @var string
     */
    protected $title = '';


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