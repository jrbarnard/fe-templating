<?php
namespace Proto;

use Proto\Exceptions\NotFoundException;

/**
 * Class Template
 * Takes a page, uses to render a twig template
 * @package App
 */
class Template
{
    public $page;
    public $content = array();
    public $template_name = '';
    public $twig;

    /**
     * Template constructor.
     * @param \Proto\Page $page
     * @throws NotFoundException
     */
    public function __construct(Page $page)
    {
        $this->page = $page;

        $this->content = self::getContent($page);

        if (isset($page->page['template'])) {
            $this->template_name = $page->page['template'];
        }

        if (self::templateFileExists($this->template_name)) {
            $this->twig = Twig::init();

            /**
             * Load twig functions in batches
             */
//            $twig->loadTwigFunctions(array(
//                "getPageTitle" => array($page, 'getTitle'),
//                "getPageDescription" => array($page, 'getDescription')
//            ));

            /**
             * Add global page var into global
             */
            $this->twig->addGlobal('current_page', array_merge(
                $page->page,
                array('uri' => $page->uri)
            ));

        } else {
            throw new NotFoundException('A template file does not exist for this route');
        }
    }

    /**
     * Method that will render the twig template stored
     * @throws \Exception
     */
    public function render()
    {
        if (self::templateFileExists($this->template_name)) {
            $this->twig->loadTemplate($this->template_name);
            $this->twig->render($this->content);
        }
    }

    /**
     * Method that takes the current page and builds up the template object for it
     * @param \Proto\Page $page
     * @return Template
     */
    public static function build(Page $page)
    {
        return new Template($page);
    }

    /**
     * Method to get the content for a page
     * @param \Proto\Page $page
     * @return array of variables
     */
    private static function getContent(Page $page) {
        $content_file_name = isset($page->page) && isset($page->page['content']) ? $page->page['content'] : false;

        // check if just passed in via structure
        if (is_array($content_file_name)) {
            return $content_file_name;
        }

        if (true === self::doesContentFileExist($content_file_name)) {
            $json = file_get_contents(self::getContentFilePath($content_file_name));
            $decoded = json_decode($json, true);

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
    public static function getContentPath()
    {
        return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'content' . DIRECTORY_SEPARATOR;
    }

    /**
     * Static function for getting template path
     * @return mixed
     */
    public static function getTemplatePath()
    {
        return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;
    }

    /**
     * Method to get template file path
     * @param bool $template_file_name
     * @return bool|string
     */
    private static function getTemplateFilePath($template_file_name = false)
    {
        if (false !== $template_file_name) {
            return self::getTemplatePath() . $template_file_name . '.twig';
        } else {
            return false;
        }
    }

    /**
     * Method to check if a template file exists
     *
     * @param $template_name
     *
     * @return boolean depending on existence
     */
    private static function templateFileExists($template_name = false) {
        if (
            false !== $template_name &&
            file_exists(self::getTemplateFilePath($template_name))
        ) {
            return true;
        } else {
            return false;
        }
    }
}