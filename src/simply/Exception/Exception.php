<?php

namespace Simply\Exception;

use Simply\Http\Response;

/**
 * Class Exception
 * @package Simply\Exception
 */
class Exception extends \RuntimeException {

    private static $debug = false;

    /**
     * @param bool $debug
     */
    public static function setTypeOfDebug(bool $debug = false) : void {
        static::$debug = $debug;
    }

    /**
     * @param $exception
     */
    public static function exceptionHandler($exception) : void {
        $response = new Response();
        if(static::$debug){
            echo '<h1>Error</h1>';
            echo '<p>Uncaught exception: "'.get_class($exception). '"</p>';
            echo '<p>Message: ' .$exception->getMessage(). '</p>';
            echo '<p>Stack Trace: <pre>'. $exception->getTraceAsString() .'</pre></p>';
            echo '<p>Throw in ['.$exception->getFile().'] on line ' .$exception->getLine(). '.</p>';
        } else {
            ini_set('error_log', STORAGE.'logs/'. date('d-m-Y' ) . '.log');
            $message = 'Uncaught exception: ' . get_class($exception);
            $message .= ' Message: ' . $exception->getMessage();
            $message .= "\nStack Trace: " . $exception->getTraceAsString();
            $message .= "\nThrow in [" . $exception->getFile() . "] on line " . $exception->getLine() . ".\n\n";
            error_log($message);

            if($exception->getCode() === 500){
                $response->error500();
            }
            $response->error404();
        }

    }

}