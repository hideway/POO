<?php

function dd($var){
    die(var_dump($var));
}

function dispatcher(callable $routeDefinitionCallback, $route)  {
    $routeCollector = new \Simply\Routing\RouteCollector(
        new \Simply\Routing\RouteGenerator(),
        new \Simply\Routing\RouteResolver($route)
    );
    $routeDefinitionCallback($routeCollector);
    return $routeCollector->renderRouteCollection();
}