<?php

namespace Simply\Routing;

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
        static::$config = $app->get('Config');
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
     * @return mixed
     */
    Public function callController($routeInfo) {
        switch ($routeInfo[0]) {
            case 200:
                $controller = $routeInfo[1];
                $action = $routeInfo[2];
                $parameters = $routeInfo[3];

                $reflector = new \ReflectionClass($controller);
                $construct = $this->setConstructorController($reflector);
                $params = $this->setConstructorMethod($reflector, $action, $parameters);

                if($construct && $params){
                    return (new $controller(...$construct))->$action(...$params);
                } elseif ($construct) {
                    return (new $controller(...$construct))->$action();
                } elseif ($params) {
                    return (new $controller())->$action(...$params);
                } else {
                    return (new $controller())->$action();
                }

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
     * @param \ReflectionClass $reflector
     * @return array|bool
     */
    protected function setConstructorController(\ReflectionClass $reflector){

        $dependenciesClass = [];
        foreach ($reflector->getConstructor()->getParameters() as $params) {
            // dependencies for the constructor
            if(! is_null($params->getType())){
                $inject = $params->getClass()->getName();
                $dependenciesClass[] = new $inject;
            } else {
                $dependenciesClass[] = $params;
            }
        }

        if(!empty($dependenciesClass)){
            return $dependenciesClass;
        }
        return false;

    }

    /**
     * @param \ReflectionClass $reflector
     * @param $action
     * @param $parameters
     * @return array|bool
     */
    protected function setConstructorMethod(\ReflectionClass  $reflector, $action, $parameters) {

        $dependenciesMethod = [];
        foreach ($reflector->getMethod($action)->getParameters() as $params){
            // dependencies for this method
            if(! is_null($params->getType())){
                $inject = $params->getClass()->getName();
                $dependenciesMethod[] = new $inject;
            }
        }

        if(!empty($parameters)){
            array_push($dependenciesMethod, $parameters);
        }

        if(!empty($dependenciesMethod)){
            return $dependenciesMethod;
        }
        return false;

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
                    foreach ($elementsOfUri as $key => $element) {
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