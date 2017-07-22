<?php

namespace Simply\Routing;

/**
 * Class RouteResolver
 * @package Simply\Routing
 */
class RouteResolver {

    /**
     * @param string $uri
     * @return string
     */
    private function getUriWithBackSlash(string $uri): string {
        return str_replace('/', '\\/', $uri);
    }

    /**
     * Transform a string to make regular expressions
     * @param string $route
     * @return string
     */
    private function getPatternForPregMatch(string $route): string {
        return '#^'. str_replace('/', '\\\/', $route) .'$#';
    }

    /**
     * @param $variables
     */
    private function pushVariablesInGet($variables) : void {
        $_GET = array_merge($_GET, $variables);
    }

}