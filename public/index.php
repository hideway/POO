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
define('STORAGE', BASE.'storage/');
define('CONFIG', BASE.'config/');
define('APP', BASE.'app/');

/**
 * Bootstrap file to load the composer autoloader
 */
require APP.'bootstrap.php';

$config = require APP.'kernel.php';


?>
