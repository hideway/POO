<?php

namespace Simply;

abstract class BaseController {

    private $renderView = null;
    private $parameters = [];
    private $controller = '';
    private $action = '';
    private $view = '';
    private $app;


    public function __construct($app, string $controller, string $action, array $parameters = null)
    {
        $this->renderView = $app->get('ViewInterface');
        $this->setParameters($parameters);
        $this->setController($controller);
        $this->setAction($action);
        $this->app = $app;
    }

    private function setController(string $controller) {
        $this->controller = $controller;
    }

    private function setAction(string $action) {
        $this->action = $action;
    }

    private function setParameters(array $parameters = null) {
        $this->parameters = $parameters;
    }

    public function render(string $viewFile, array $vars = []) {
        $this->view = $this->renderView->callViewRender($viewFile, $vars);
        $this->app->get('Response')->send($this->view);
    }



}