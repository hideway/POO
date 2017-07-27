<?php

namespace Simply\Session;

session_start();

class Session {

    public function getSession($key) : ?string {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public function setSession(string $key, string $value) : void {
        $_SESSION[$key] = $value;
    }

}