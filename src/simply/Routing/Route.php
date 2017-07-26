<?php

namespace Simply\Routing;

use Simply\Http\Request;

/**
 * Class Route
 * @package Simply\Routing
 */
class Route
{

    public $method;
    public $uri;
    public $request;

    /**
     * Route constructor.
     * @param Request $request
     */
    public function __construct(Request $request) {
        $this->method = $request->method();
        $this->uri = $request->uri();
        $this->request = $request->request();
    }

    /**
     * @param array $request
     */
    public function setRequest(array $request) : void {
        $this->request = $request;
    }

}