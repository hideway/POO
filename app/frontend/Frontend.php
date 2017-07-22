<?php

namespace App\Frontend;

use Simply\BaseApplication;
use Simply\Routing\Router;

/**
 * Entry point of frontend environment
 * Class Frontend
 * @package App\Frontend
 */
class Frontend extends BaseApplication
{

    public function run(): void {

        $this->app->set('Router', new Router($this->app->get('App')));
        $this->app->get('Router')->callController($this->app->get('Router')->getCurrentRouteInfo($this->app->get('Router')->getRoutes()), $this->app);


    }

}