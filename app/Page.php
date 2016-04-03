<?php

namespace App;

use Whoops\Exception\ErrorException;

class Page
{

    public $uri = '';
    public $page;
    public $level;

    public function __construct($props = array())
    {
        $this->setProperties($props);
    }

    /**
     * Method to set properties from passed in array only if they exist
     * @param array $props
     * @throws ErrorException
     */
    private function setProperties($props = array())
    {
        if (empty($props)) {
            throw new ErrorException('You need to pass valid properties to create a page');
        }

        foreach($props as $prop => $value) {
            if (false !== property_exists($this, $prop)) {
                $this->{$prop} = $value;
            }
        }
    }
}