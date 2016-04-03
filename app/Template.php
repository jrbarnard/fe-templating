<?php

namespace App;

use App\Page;

class Template
{
    public $page;

    public function __construct(Page $page)
    {
        $this->page = $page;

        $this->content = $this->getContent($this->page);
    }

    public static function build(Page $page)
    {
        return new Template($page);
    }

    /**
     * Method to get the content for a page
     * @param \App\Page $page
     * @return array of variables
     */
    private static function getContent(Page $page) {
        $content_file_name = isset($page->page) && isset($page->page->content) ? $page->page->content : false;

        if (true === self::doesContentFileExist($content_file_name)) {
            $json = file_get_contents(self::getContentFilePath($content_file_name));
            $decoded = json_decode($json);

            if (
                false !== $json &&
                null !== $decoded
            ) {
                return $decoded;
            }
        }
        return array();
    }

    /**
     * Method to check if a content file exists
     * @param bool $content_file_name
     * @return bool
     */
    private static function doesContentFileExist($content_file_name = false)
    {
        if (
            false !== $content_file_name &&
            false !== file_exists(self::getContentFilePath($content_file_name))
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method to get content file path
     * @param bool $content_file_name
     * @return bool|string
     */
    private static function getContentFilePath($content_file_name = false)
    {
        if (false !== $content_file_name) {
            return self::getContentPath() . $content_file_name . '.json';
        } else {
            return false;
        }
    }

    /**
     * Static function for getting content path
     * @return mixed
     */
    private static function getContentPath()
    {
        return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'content' . DIRECTORY_SEPARATOR;
    }
}