<?php

namespace App;

use \Twig_Loader_Filesystem;
use \Twig_Environment;
use \Twig_SimpleFunction;
use \Twig_Extension_Debug;
use \Exception;

class Twig
{
    public $twig_loader_filesystem;
    public $twig_environment;
    public $template = false;

    public function __construct()
    {
        // store the location of the templates
        $this->twig_loader_filesystem = new Twig_Loader_Filesystem(Template::getTemplatePath());
        $this->twig_environment = new Twig_Environment($this->twig_loader_filesystem); // create the environment

        if ('dev' === getenv('ENVIRONMENT')) {
            $this->twig_environment->enableDebug();
            $this->twig_environment->addExtension(
                new Twig_Extension_Debug()
            );
        }

//        $this->loadTwigFunctions(array(
//
//        ));
    }

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
        $this->template = $this->twig_environment->loadTemplate($template_name . '.twig');
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
            $this->twig_environment->addFunction($function);
        }
    }
}