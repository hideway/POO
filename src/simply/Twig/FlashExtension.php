<?php

namespace Simply\Twig;


use \Twig_Environment;
use \Simply\Session\Flash;

/**
 * Class RouterExtension
 * @package Simply\Twig
 */
class FlashExtension extends \Twig_Extension {

    /**
     * @return array
     */
    public function getFunctions() {
        return [
            new \Twig_SimpleFunction('flash', [$this, 'flash'], ['is_safe' => array('html')])
        ];
    }

    public function flash() {
        if(Flash::hasFlash('error')){
            return '<div class="alert alert-danger"><strong>Error !</strong>'.Flash::getFlash('error').'</div>';
        }
        if(Flash::hasFlash('success')){
            return '<div class="alert alert-success"><strong>Success !</strong>'.Flash::getFlash('success').'</div>';
        }
        if(Flash::hasFlash('warning')){
            return '<div class="alert alert-success"><strong>Warning !</strong>'.Flash::getFlash('warning').'</div>';
        }
        if(Flash::hasFlash('info')){
            return '<div class="alert alert-info"><strong>Info !</strong>'.Flash::getFlash('info').'</div>';
        }
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