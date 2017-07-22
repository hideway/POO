<?php

namespace Simply\Routing;

/**
 * Class RouteCollector
 * @package Simply\Routing
 */
class RouteCollector
{

    private $routeCollection;
    private $routeGenerator;
    private $routeResolver;

    /**
     * RouteCollector constructor.
     * @param RouteGenerator $generator
     * @param RouteResolver $resolver
     */
    public function __construct(RouteGenerator $generator, RouteResolver $resolver)
    {
        $this->routeGenerator = $generator;
        $this->routeResolver = $resolver;
    }

    /**
     * @param string $method
     * @param string $pattern
     * @param string $controllerAction
     * @param array|null $params
     */
    public function addRoute(string $method, string $pattern, string $controllerAction, ?array $params = null, ?string $name = null) : void {
        $method = $this->routeGenerator->setMethod($method);
        $uri = $this->routeGenerator->setURI($pattern);
        [$pattern, $params] = $this->routeGenerator->setPattern($pattern, $params);
        [$controller, $action] = $this->routeGenerator->setControllerAndAction($controllerAction);
        $this->routeCollection[$method][$pattern] = ['name' => $name, 'uri' => $uri, 'method' => $method,'controller' => $controller, 'action' => $action, 'parameters' => $params];
    }

    /**
     * @param string $pattern
     * @param string $controllerAction
     * @param array|null $params
     */
    public function get(string $pattern, string $controllerAction, ?array $params = null, ?string $name = null) :void {
        $this->addRoute('GET', $pattern, $controllerAction, $params, $name);
    }

    /**
     * @param string $pattern
     * @param string $controllerAction
     * @param array|null $params
     */
    public function post(string $pattern, string $controllerAction, ?array $params = null, ?string $name = null) : void {
        $this->addRoute('POST', $pattern, $controllerAction, $params, $name);
    }

    /**
     * @return array
     */
    public function renderRouteCollection() : array {
        return $this->routeCollection;
    }


}