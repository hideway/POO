<?php

namespace Simply\Routing;

use Simply\BaseController;
use Simply\Exception\NotFoundException;
use Simply\Exception\MethodNotAllowedException;

/**
 * Class Router
 * @package Simply\Routing
 */
class Router {

    protected $app;


    /**
     * Router constructor.
     * @param $app
     */
    public function __construct($app) {
        $this->app = $app;
    }

    /**
     * @return array
     */
    public function getRoutes() : array {
        return dispatcher(function (RouteCollector $route) {
            // Include the routes of application
            require $this->app->get('Config')->routesFile;
        }, $this->app->get('Route'));
    }

    /**
     * @param $routes
     * @return array
     */
    public function getCurrentRouteInfo($routes) : array {
        $dispatcher = new RouteDispatcher($routes);
        return $dispatcher->dispatch($this->app->get('Route'));
    }


    /**
     * @param $routeInfo
     * @param $app
     * @return BaseController
     */
    Public function callController($routeInfo, $app) : BaseController {
        switch ($routeInfo[0]) {
            case 200:

                $controller = $routeInfo[1];
                $action = $routeInfo[2];
                $parameters = $routeInfo[3];

                if(!is_null($parameters)){
                    return (new $controller($app, $controller, $action, $parameters))->$action(...array_values($parameters));
                }
                return (new $controller($app, $controller, $action, $parameters))->$action();

                break;
            case 404:
                throw new NotFoundException('page not found', 404);
                break;
            case 405:
                throw new MethodNotAllowedException('this method has not allowed', 405);
                break;
        }
    }


}