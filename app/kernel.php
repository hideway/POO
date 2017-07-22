<?php

use function DI\get;
use function DI\object;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(BASE.'/.env');

$config = [];
$files = glob(sprintf(CONFIG.'{{,*.}global,{,*.}%s}.php', getenv('APP_ENV') ? : 'production'), GLOB_BRACE);

foreach ($files as $file) {
    $config = array_merge($config, include $file);
}

$config = new ArrayObject($config, ArrayObject::ARRAY_AS_PROPS);

return [

    // Config
    'Config' => $config,

    // HTTP
    \Simply\Http\Request::class => object(),
    'Request' => get(\Simply\Http\Request::class),
    \Simply\Http\Response::class => object(),
    'Response' => get(\Simply\Http\Response::class),


    // Routing
    \Simply\Routing\Route::class => object()->constructor(get('Request')),
    'Route' => get(\Simply\Routing\Route::class),
    \Simply\Routing\RouteGenerator::class => object(),
    'RouteGenerator' => get(\Simply\Routing\RouteGenerator::class),
    \Simply\Routing\RouteResolver::class => object(),
    'RouteResolver' => get(\Simply\Routing\RouteResolver::class),
    \Simply\Routing\RouteCollector::class => object()->constructor(get('RouteGenerator'), get('RouteResolver')),
    'RouteCollector' => get(\Simply\Routing\RouteCollector::class),


    // Database
    \Simply\Database\Database::class => object()->constructor(
        $config->db_name,
        $config->db_host,
        $config->db_port,
        $config->db_user,
        $config->db_pass,
        $config->db_options
    ),
    'Database' => get(\Simply\Database\Database::class),

    // View
    'TwigLoader' => object('\Twig_Loader_Filesystem')->constructor(
        array($config->layoutFile, $config->folderView)
    ),
    'Twig' => object('\Twig_Environment')->constructor(
        get('TwigLoader'),
        array(
            'cache' => $config->cacheView,
            'debug' => $config->debug
        )
    ),
    \Simply\View\ViewTwig::class => object()->constructor(get('TwigLoader'), get('Twig')),
    'ViewTwig' => get(\Simply\View\ViewTwig::class),
    \Simply\View\ViewInterface::class => \DI\get('ViewTwig'),
    'ViewInterface' => get (\Simply\View\ViewInterface::class),

    // Exception
    \Simply\Exception\ViewFileNotFoundException::class => object(),
    \Simply\Exception\MethodNotAllowedException::class => object(),
    \Simply\Exception\NotFoundException::class => object()


];