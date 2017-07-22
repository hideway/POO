<?php

namespace Simply\Twig;


use \Twig_Environment;
use Simply\Routing\Router;

/**
 * Class RouterExtension
 * @package Simply\Twig
 */
class RouterExtension extends \Twig_Extension {

    /**
     * @return array
     */
    public function getFunctions() {
        return [
            new \Twig_SimpleFunction('isActive', [$this, 'isActive'], ['needs_context' => true]),
            new \Twig_SimpleFunction('url', [$this, 'url']),
            new \Twig_SimpleFunction('link', [$this, 'link'])
        ];
    }

    /**
     * @param array $context
     * @param $page
     * @return string
     */
    public function isActive(array $context, $page) {
        var_dump($context);
        if(isset($context['current_page']) && $context['current_page'] === $page) {
            return ' active ';
        }
    }

    /**
     * @param string $path
     * @param string $text
     * @param bool $base
     */
    public function url(string $path, string $text, bool $base = false) {
        return Router::url($path, $text, $base);
    }

    /**
     * @param string $name
     * @param string $text
     * @param array $vars
     * @param bool $base
     */
    public function link(string $name, string $text, array $vars = [], bool $base = false) {
        return Router::link($name, $text, $vars, $base);
    }


    /**
     * Initializes the runtime environment.
     *
     * This is where you can load some file that contains filter functions for instance.
     *
     * @param Twig_Environment $environment The current Twig_Environment instance
     *
     * @deprecated since 1.23 (to be removed in 2.0), implement Twig_Extension_InitRuntimeInterface instead
     */
    public function initRuntime(Twig_Environment $environment)
    {
        // TODO: Implement initRuntime() method.
    }

    /**
     * Returns a list of global variables to add to the existing list.
     *
     * @return array An array of global variables
     *
     * @deprecated since 1.23 (to be removed in 2.0), implement Twig_Extension_GlobalsInterface instead
     */
    public function getGlobals()
    {
        // TODO: Implement getGlobals() method.
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        // TODO: Implement getName() method.
    }
}