<?php

namespace Simply\Routing;

/**
 * Class RouteGenerator
 * @package Simply\Routing
 */
class RouteGenerator {

    /**
     * @param string $method
     * @return string
     */
    public function setMethod(string $method): string {
        return $method;
    }

    /**
     * @param string $name
     * @return string
     */
    public function setName(?string $name): ?string {
        return $name;
    }

    /**
     * @param string $uri
     * @return string
     */
    public function setURI(string $uri) : string {
        return preg_replace('#({)([a-z]+)(})#', ':$2:', $uri);
    }

    /**
     * @param string $pattern
     * @param array|null $params
     * @return array
     */
    public function setPattern(string $pattern, ?array $params = null) : array {

        $pattern = str_replace('/', '\\/', $pattern);
        if(is_iterable($params)) {
            foreach ($params as $keyVariables => $variable) {
                $variables[$keyVariables] = $variable;
            }

            $parametersBetweenColon = preg_replace('#({)([a-z]+)(})#', ':$2:', $pattern);
            $elementsOfUrlInArray = explode(':', trim($parametersBetweenColon, ':'));


            foreach ($elementsOfUrlInArray as $key => $element){
                foreach ($params as $keyVariables => $variable){
                    if($element === $keyVariables){
                        $elementsOfUrlInArray[$key] = '('.$variable.')';
                    }
                }
            }

            return [implode($elementsOfUrlInArray), $params];

        } else {
            return [$pattern, null];
        }
    }

    /**
     * @param string $controllerAction
     * @return array
     * @throws \AssertionError
     */
    public function setControllerAndAction(string $controllerAction) : array {
        if(!strpos($controllerAction, '@')){
            throw new \AssertionError('This string ('.$controllerAction.') does not contains an @');
        }
        return explode('@', $controllerAction);
    }

}