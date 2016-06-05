<?php

namespace App;

use \Twig_Loader_Filesystem;
use \Twig_Environment;
use \Twig_SimpleFunction;
use \Twig_Extension_Debug;
use \Exception;

/**
 * Class Twig
 * Builds up twig instance
 *
 * @package App
 */
class Twig
{
    /**
     * @var Twig_Loader_Filesystem
     */
    public $twigLoaderFilesystem;

    /**
     * @var Twig_Environment
     */
    public $twigEnvironment;
    public $template = false;

    /**
     * Twig constructor.
     */
    public function __construct()
    {
        $this->buildTwigLoader();

        $this->buildTwigEnvironment();

        if ('dev' === getenv('ENVIRONMENT')) {
            $this->enableDebug();
        }
    }

    /**
     * Enable debug settings with twig
     * @return $this
     */
    protected function enableDebug()
    {
        $this->twigEnvironment->enableDebug();
        $this->twigEnvironment->addExtension(
            new Twig_Extension_Debug()
        );

        // Add dev helper functions
        $this->loadTwigFunctions(array(
            'dd' => 'dd',
            'd' => 'd'
        ));

        return $this;
    }

    /**
     * Generate the twig environment
     * @return $this
     */
    protected function buildTwigEnvironment()
    {
        /**
         * Set up environment information
         */
        $twig_env_options = array(
            "cache" => self::getTwigCachePath()
        );
        if ('dev' === getenv('ENVIRONMENT')) {
            // we have to set here otherwise we cache too much
            $twig_env_options["debug"] = true;
        }

        /**
         * Generate thw twig environment
         */
        $this->twigEnvironment = new Twig_Environment($this->twigLoaderFilesystem, $twig_env_options);

        return $this;
    }

    /**
     * store the location of the templates with twig
     * @return $this
     */
    protected function buildTwigLoader()
    {
        $this->twigLoaderFilesystem = new Twig_Loader_Filesystem(Template::getTemplatePath());

        return $this;
    }

    /**
     * Method to initialise a twig object
     * @return Twig
     */
    public static function init()
    {
        return new Twig();
    }

    /**
     * Method that loads a template by name
     * @param bool $template_name
     * @throws Exception
     */
    public function loadTemplate($template_name = false)
    {
        if (false === $template_name) {
            throw new Exception('Need to pass a valid template name');
        }
        $this->template = $this->twigEnvironment->loadTemplate($template_name . '.twig');
    }

    /**
     * Method that renders the set template
     * @param array $content
     * @throws Exception
     */
    public function render($content = array())
    {
        if (false === is_array($content)) {
            throw new Exception('You must pass a valid (can be empty) array as content to twig render');
        }

        if (false === $this->template) {
            throw new Exception('You are calling render before setting a valid template');
        }

        echo $this->template->render($content);
    }

    /**
     * Method that takes an array of helpers (functions)
     * stored as key => method name, if method of class stored as array(className, methodName)
     * @param array $helpers
     */
    public function loadTwigFunctions($helpers = array())
    {
        foreach($helpers as $name => $method) {
            $function = new Twig_SimpleFunction($name, $method);
            $this->twigEnvironment->addFunction($function);
        }
    }

    /**
     * Method to run twig add global method
     * @param $name
     * @param $value
     */
    public function addGlobal($name, $value)
    {
        $this->twigEnvironment->addGlobal($name, $value);
    }

    /**
     * Method to get the specific twig cache path
     * @return string
     */
    public static function getTwigCachePath()
    {
        return App::getCachePath() . 'twig' . DIRECTORY_SEPARATOR;
    }
}