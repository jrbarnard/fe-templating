<?php

namespace App;

use \InvalidArgumentException;

class Page
{
    public $uri = '';
    public $level = 0;
    public $page = array(
        "hidden" => false,
        "breadcrumbs" => true
    );

    public function __construct($props = array())
    {
        $this->setProperties($props);
    }

    /**
     * Method to set properties from passed in array only if they exist
     * @param array $props
     * @throws InvalidArgumentException
     */
    private function setProperties($props = array())
    {
        if (empty($props)) {
            throw new InvalidArgumentException('You need to pass valid properties to create a page');
        }

        // uses setter methods for each property so we can set defaults / massage
        foreach($props as $prop => $value) {
            $method_name = 'set' . ucwords($prop) . 'Prop';
            if (false !== method_exists($this, $method_name)) {
                $this->{$method_name}($value);
            }
        }
    }

    /**
     * Method to set level page property
     * @param int $value
     * @throws InvalidArgumentException
     */
    private function setLevelProp($value = 0)
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException('You must pass a valid numeric value as a level property');
        }
        $this->level = $value;
    }

    /**
     * Method to set uri property
     * @param string $value
     * @throws InvalidArgumentException
     */
    private function setUriProp($value = '')
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException('You must pass a string as uri property');
        }
        $this->uri = $value;
    }

    /**
     * method to set the page property, taking into account defaults
     * @param array $value
     * @throws InvalidArgumentException
     */
    private function setPageProp($value = array())
    {
        if (!is_array($value)) {
            throw new InvalidArgumentException('The page property must be an array');
        }
        $defaults = $this->page;

        $this->page = array_merge($defaults, $value);
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