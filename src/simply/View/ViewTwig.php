<?php

namespace Simply\View;

use Simply\Twig\RouterExtension;

class ViewTwig implements ViewInterface
{

    protected $loader;
    protected $twig;

    public function __construct($loader, $twig) {
        $this->loader = $loader;
        $this->twig = $twig;

        $this->twig->addExtension(new RouterExtension());
        $this->twig->addExtension(new \Twig_Extension_Debug());
        $this->twig->addGlobal('current_page', ($_SERVER['REQUEST_URI'] === '/') ? $_SERVER['REQUEST_URI'] : rtrim($_SERVER['REQUEST_URI'], '/'));
    }

    public function callViewRender(string $fileView, array $data = []){
        return $this->twig->render($fileView, $data);
    }

}