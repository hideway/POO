<?php

namespace Simply\View;

class ViewTwig implements ViewInterface
{

    protected $loader;
    protected $twig;

    public function __construct($loader, $twig) {
        $this->loader = $loader;
        $this->twig = $twig;
    }

    public function callViewRender(string $fileView, array $data = []){
        return $this->twig->render($fileView, $data);
    }

}