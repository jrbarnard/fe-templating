<?php

namespace App;

class Page
{

    public function __construct()
    {

    }

    

    /**
     * Searches through the structure for a page, if it exists it returns the page, else returns false
     * NB: this only checks within the current uri structure (as it's only for getting valid pages - searching the tree without a route would be overly inefficient for our needs)
     *
     * @param $page - page object to use
     * @param $page_slug - page sluf to use
     *
     * @return page object or false if doesn't exist
     */
    public function searchForPage(Page $page, $page_slug) {
        // check for single case and return value
        if ($page->levels == 1) {
            $return = new stdClass();
            $return->uri = $this->uri_structure[0];
            $return->page = $this->get_page($this->uri_structure[0]);
            $return->level = 0;
            return $return;
        }

        // store a pointer so we can walk to array
        $pointer = $this->structure;
        // iterate over pages
        for ($i = 0; $i < $this->pages; $i++) {
            if ($i > 0) {
                $pointer = $pointer['children'];
            }
            $pointerpage = $this->get_page($this->uri_structure[$i], $pointer);
            // if there is a page on this level as part of the uri structure
            if ($pointerpage !== false) {
                // there is a page so check if it is the one we're looking for
                if ($this->uri_structure[$i] == $page) {
                    // it is, store the page and level in an object and return
                    $return = new stdClass();
                    $return->uri = $this->uri_structure[$i];
                    $return->page = $pointerpage;
                    $return->level = $i;
                    return $return;
                }
                // else set the pointer and iterate
                $pointer = $pointerpage;
            } else {
                return false;
            }
        }
    }
}