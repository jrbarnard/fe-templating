<?php

namespace App;

use \Exception;

class Page
{

    public $uri = '';
    public $page = array();
    public $level = 0;

    public function __construct($props = array())
    {
        $this->setProperties($props);
    }

    /**
     * Method to set properties from passed in array only if they exist
     * @param array $props
     * @throws Exception
     */
    private function setProperties($props = array())
    {
        if (empty($props)) {
            throw new Exception('You need to pass valid properties to create a page');
        }

        foreach($props as $prop => $value) {
            if (false !== property_exists($this, $prop)) {
                $this->{$prop} = $value;
            }
        }
    }

    /**
     * General method for getting a page property
     * @param bool $prop
     * @return string
     */
    public function getPageProp($prop = false)
    {
        if (false === $prop) {
            return "";
        }

        if (false !== isset($this->page[$prop])) {
            return $this->page[$prop];
        } else {
            return "";
        }
    }

    /**
     * Method to get page title
     * @return string
     */
    public function getTitle()
    {
        return $this->getPageProp('title');
    }
    /**
     * Method to get page title
     * @return string
     */
    public function getDescription()
    {
        return $this->getPageProp('description');
    }

    /**
     * Static method for generating the 404 page
     * @return Page
     */
    public static function page404()
    {
        return new Page(array(
            'page' => array(
                'title' => '404 - Page not found',
                'description' => 'Your page wasn\'t found',
                'template' => '404'
            )
        ));
    }
}