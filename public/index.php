<?php declare(strict_types=1);

/**
 * Front controller
 *
 * PHP version 7.1
 */


/**
 * Application constants
 */
define('DS', DIRECTORY_SEPARATOR);
define('BASE', dirname(__DIR__).DS);
define('APP', BASE.'app/');


/**
 * Bootstrap file to load the composer autoloader
 */
require APP.'bootstrap.php';

?>