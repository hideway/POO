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
define('GATE', (preg_match('#^/admin#', $_SERVER['REQUEST_URI'])) ? 'backend' : 'frontend');


/**
 * Bootstrap file to load the composer autoloader
 */
require APP.'bootstrap.php';


/**
 * Start Application
 */

$appStart = '\\App\\'.ucfirst(GATE).'\\'.ucfirst(GATE); // Entry point (Frontend or Backend)
$app = new $appStart(require APP.'kernel.php');
$app->run();


?>
