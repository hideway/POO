<?php

namespace Simply\Http;

/**
 * Class Request
 * @package Simply\Http
 */
class Request
{

    /**
     * @return null|string
     */
    public function method() : ?string {
        return ($_SERVER['REQUEST_METHOD'] === 'GET' || $_SERVER['REQUEST_METHOD'] === 'POST') ? $_SERVER['REQUEST_METHOD'] : null;
    }

    /**
     * @return string
     */
    public function uri() : string {
        return ($_SERVER['REQUEST_URI'] === '/') ? $_SERVER['REQUEST_URI'] : rtrim($_SERVER['REQUEST_URI'], '/');
    }

    public function setRequest($parameters) : ?array {
        array_merge($_REQUEST, $parameters);
    }

    /**
     * @return array|null
     */
    public function request() : ?array {
        return ($_REQUEST) ? $_REQUEST : null;
    }

    /**
     * @return array|null
     */
    public function get() : ?array {
        return ($_GET) ? $_GET : null;
    }

    /**
     * @return array|null
     */
    public function post() : ?array {
        return ($_POST) ? $_POST : null;
    }

}