<?php

namespace Simply;

use DI\Container;

abstract class BaseController {

    protected $app;
    protected $renderView;

    public function __construct($app)
    {
        $this->app = $app;
        $this->renderView = $this->app->get('ViewInterface');
    }

    public function callAction($action, $parameters) {
        return call_user_func_array([$this, $action], $parameters);
    }


    public function render(string $viewFile, array $vars = []) {
        $this->view = $this->renderView->callViewRender($viewFile, $vars);
        $this->app->get('Response')->send($this->view);
    }

}