<?php

namespace Simply\Error;

/**
 * Class Error
 * @package Simply\Error
 */
class Error {

    /**
     * @param $level
     * @param $message
     * @param $file
     * @param $line
     * @throws \ErrorException
     */
    public static function errorHandler($level, $message, $file, $line){
        if(error_reporting(E_ALL) !== 0) {
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

}