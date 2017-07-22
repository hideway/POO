<?php

namespace App\Frontend\Controllers;

use Simply\BaseController;

class HomeController extends BaseController
{

    public function indexAction(){
        return $this->render('home/index.twig');
    }

}