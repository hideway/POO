<?php


namespace Simply\Http;

/**
 * Class Response
 * @package Simply\Http
 */
class Response {

    public $headers = [];
    public $statusCode;

    /**
     * @param string $body
     * @return string
     */
    public function send(string $body) : string {
        $this->setHeaders();
        $this->setStatusCode(200);
        die($body);
    }

    /**
     * @param string $url
     * @param int $statusCode
     */
    public function redirect(string $url, int $statusCode = 303) : void {
        header('Location: ' . $url, true, $statusCode);
        die();
    }


    public function error404() : void {
        $this->setStatusCode(404);
        die(require APP.'template/errors/400/404.html');
    }

    public function error500() : void {
        $this->setStatusCode(500);
        die(require APP.'template/errors/500/500.html');
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode(int $statusCode) : void {
        http_response_code($statusCode);
        $this->statusCode = $statusCode;
    }

    /**
     * @return int
     */
    public function getStatusCode() : int {
        if(is_null($this->statusCode)){
            $this->statusCode = http_response_code();
        }
        return $this->statusCode;
    }

    /**
     * @param string $header
     */
    public function setHeader(string $header) : void {
        header($header);
        $this->setHeaders();
    }

    /**
     * set headers
     */
    public function setHeaders() : void {
        $this->headers = headers_list();
    }
    /**
     * @return array|null
     */
    public function getHeaders() : ?array {
        return $this->headers;
    }

    /**
     * @param string $name
     * @param string $value
     * @param int $expire
     * @param string|null $path
     * @param string|null $domain
     * @param bool $secure
     * @param bool $httpOnly
     */
    public function setCookie(string $name, string $value = '', int $expire = 0, string $path = null, string $domain = null, bool $secure = false, bool $httpOnly = true) {
        setcookie($name, $value, $expire, $path, $domain, $secure, $httpOnly);
    }

}