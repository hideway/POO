<?php

namespace Simply\Session;


class Flash extends Session
{

    public function setFlash(string $type, string $value) : void {
        $_SESSION['flash'][$type] = $value;
    }


    public static function getFlash(string $type) : ?string {
        $flash = $_SESSION['flash'][$type];
        unset($_SESSION['flash'][$type]);
        return $flash;
    }

    public static function hasFlash(string $type) : ?string{
        return isset($_SESSION['flash'][$type]) ? $_SESSION['flash'][$type] : null;
    }
}