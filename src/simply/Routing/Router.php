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
    protected static $config;


    /**
     * Router constructor.
     * @param $app
     */
    public function __construct($app) {
        $this->app = $app;
        static::$config = $this->app->get('Config');
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

    /**
     * @param string $path
     * @param string $text
     * @param bool $base
     * @return void
     */
    public static function url(string $path, string $text, bool $base = false) : void {
        echo ($base) ? '<a href="' . static::$config->url . '/' . $path . '">' . $text . '</a>' : '<a href="'. $path .'">' . $text . '</a>';
    }

    /**
     * @param string $name
     * @param string $text
     * @param array $vars
     * @param bool $base
     * @return void
     */
    public static function link(string $name, string $text, array $vars = [], bool $base = false) : void {

        $routes = fileUnserialized(static::$config->cachedRoutesFile);

        if(isset($routes['GET']) && isset($route['POST'])) {
            $routesList = array_merge($routes['GET'], $routes['POST']);
        } else {
            $routesList = $routes['GET'];
        }

        foreach ($routesList as $route => $parameters){
            if($parameters['name'] === $name){

                $elementsOfUri = explode(':', trim($parameters['uri'], ':'));
                foreach ($vars as $k => $v){
                    foreach ($elementsOfUri as $key => $element){
                        if($element === $k) {
                            $elementsOfUri[$key] = $v;
                        } else {
                            $elementsOfUri[$key] = $element;
                        }
                    }
                }
                $uri = implode($elementsOfUri);
            }

        }

        echo ($base) ? '<a href="' . static::$config->url . $uri . '">' . $text . '</a>' : '<a href="'. $uri .'">' . $text . '</a>';

    }



}