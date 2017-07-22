<?php

/**
 * @param $var
 */
function dd($var){
    die(var_dump($var));
}

/**
 * @param $data
 * @param $filePath
 */
function fileSerialized($data, $filePath) : void {
    if($file = fopen($filePath,'w')){
        $dataSerialized = serialize($data);
        fwrite($file, $dataSerialized);
        fclose($file);
    } else {
        throw new \LogicException('Cannot open file in : ' . $filePath);
    }
}

/**
 * @param $filePath
 * @return mixed
 */
function fileUnserialized($filePath) : array {
    if($file = fopen($filePath,'r')){
        $dataUnserialized = unserialize(fread($file, filesize($filePath)));
        fclose($file);
        return $dataUnserialized;
    } else {
        throw new \LogicException('Cannot open file in : ' . $filePath);
    }
}


/**
 * @param callable $routeDefinitionCallback
 * @param $route
 * @return array
 */
function dispatcher(callable $routeDefinitionCallback, $route) : array {

    $cacheRouteCollection = STORAGE.'cache/routing/'.GATE.'_cached_route_collection';

    if(!file_exists($cacheRouteCollection)){

        $routeCollector = new \Simply\Routing\RouteCollector(
            new \Simply\Routing\RouteGenerator(),
            new \Simply\Routing\RouteResolver($route)
        );

        $routeDefinitionCallback($routeCollector);

        fileSerialized($routeCollector->renderRouteCollection(), $cacheRouteCollection);

        return $routeCollector->renderRouteCollection();

    } else {

        return fileUnserialized($cacheRouteCollection);

    }

}