<?php

namespace Simply\Routing;

/**
 * Class RouteDispatcher
 * @package Simply\Routing
 */
class RouteDispatcher
{

    public const METHOD_NOT_ALLOWED = 405;
    public const NOT_FOUND = 404;
    public const FOUND = 200;

    private $routesCollection;


    /**
     * RouteDispatcher constructor.
     * @param array $routesCollection
     */
    public function __construct(array $routesCollection) {
        $this->routesCollection = $routesCollection;
    }


    /**
     * @param Route $currentRoute
     * @return array
     */
    public function dispatch(Route $currentRoute): array {
        foreach ($this->routesCollection[$currentRoute->method] as $pattern => $parameters){

            if($params = $this->match($pattern, $currentRoute)){
                array_shift($params);
                if(count($params) > 0){
                    $i = 0;
                    foreach ($parameters['parameters'] as $k => $v){
                        $parameters['parameters'][$k] = $params[$i];
                        $i++;
                    }
                    $currentRoute->setRequest($parameters['parameters']);

                }

                $controller = '\\App\\'.ucfirst(GATE).'\\Controllers\\'.$parameters['controller'];
                $action = $parameters['action'].'Action';
                if(!method_exists($controller,$action)){
                    return [static::METHOD_NOT_ALLOWED, $action];
                }

                return [static::FOUND, $controller, $action, ($parameters['parameters']) ? $parameters['parameters'] : null];
            }

        }
        return [static::NOT_FOUND];

    }

    /**
     * @param $pattern
     * @param $currentRoute
     * @return array|null
     */
    private function match($pattern, $currentRoute) : ?array {
        if(preg_match('#^' . $pattern . '$#', $currentRoute->uri, $matches)){
            return $matches;
        }
        return null;
    }


}