<?php

namespace App;

use Whoops\Exception\ErrorException;

class Structure
{
    public static $json_filename = 'structure.json';
    public $json = ''; // stores the json structure as it comes (valid or not)
    public $routes = array(); // stores the routes object within structure
    public $uri = ''; // stores uri string e.g foo/bar
    public $uri_structure = array(); // stores uri in array e.g array('foo', 'bar')
    public $levels = 1; // stores number of uri levels in current request


    protected function __construct()
    {
        $this->json = $this->getStructure();
        $this->routes = $this->convertJsonToAssocArr($this->json);

        // get and store uri info
        $this->uri = self::currentUri();
        $this->uri_structure = self::uriStructure($this->uri);
        $this->levels = count($this->uri_structure);

        // search for and store current page
        $this->current_page = self::findRoute($this, $this->uri_structure[$this->levels - 1]);
    }

    public static function init()
    {
        return new Structure();
    }

    /**
     * Gets the structure file contents
     * @return mixed
     * @throws ErrorException
     */
    private function getStructure()
    {
        if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . self::$json_filename)) {
            $json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . self::$json_filename);

            if (false !== $json) {
                return $json;
            }
        }

        throw new ErrorException('Structure file: ' . self::$json_filename . ' not found in: ' . __DIR__);
    }

    /**
     * Converts Json to associative array of routes
     * @param $json
     * @return mixed
     * @throws ErrorException
     */
    private function convertJsonToAssocArr($json)
    {
        $arr = json_decode($json);

        if (null === $arr) {
            throw new ErrorException('Json in ' . self::$json_filename . ' is invalid and couldn\'t decode');
        }

        if (false === isset($arr->routes)) {
            throw new ErrorException('Json in ' . self::$json_filename . ' didn\'t have a valid routes object');
        }

        return $arr->routes;
    }

    /**
     * Method that gets uri string from get 'p' param
     * @return string
     */
    public static function currentUri()
    {
        if (empty($_GET['p'])) {
            $_GET['p'] = '/';
        }

        return $_GET['p'];
    }

    /**
     * Method that takes a string uri and converts to an array
     * e.g test/a/link => array('test', 'a', 'link');
     * @param $uri
     * @return array
     */
    public static function uriStructure($uri)
    {
        if (empty($uri)) {
            return array();
        }

        $parts = explode('/', $uri);

        // check for empty values, unset and then reindex
        foreach ($parts as $key => $value) {
            if ("" === $value) {
                unset($parts[$key]);
            }
        }

        $parts = array_values($parts);

        return $parts;
    }

    public static function findRoute(Structure $structure, $route = false)
    {
        if (false === $route) {
            throw new ErrorException('You must pass a valid route to look up')
        }

        // check for single case and return value
        if ($structure->levels == 1) {
            return new Page(array(
                'uri' => $structure->uri_structure[0],
                'page' => $structure->getPage($structure->uri_structure[0]),
                'level' => 0
            ));
        }

        // store a pointer so we can walk to array
        $pointer = $structure->routes;
        // iterate over pages
        for ($i = 0; $i < $structure->levels; $i++) {
            if ($i > 0) {
                $pointer = $pointer['children'];
            }
            $pointerpage = $structure->getPage($structure->uri_structure[$i], $pointer);
            // if there is a page on this level as part of the uri structure
            if ($pointerpage !== false) {
                // there is a page so check if it is the one we're looking for
                if ($structure->uri_structure[$i] == $page) {
                    // it is, store the page and level in an object and return
                    return new Page(array(
                        'uri' => $structure->uri_structure[$i],
                        'page' => $pointerpage,
                        'level' => $i
                    ));
                }
                // else set the pointer and iterate
                $pointer = $pointerpage;
            } else {
                return false;
            }
        }
    }
}