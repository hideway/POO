<?php

namespace Simply\Database;

class Connector {

    private $pdo;
    private $db_name;
    private $db_host;
    private $db_port;
    private $db_user;
    private $db_pass;
    private $db_options;

    /**
     * Connector constructor.
     * @param string $db_name
     * @param string $db_host
     * @param string $db_port
     * @param string $db_user
     * @param string $db_pass
     * @param array $db_options
     */
    public function __construct(string $db_name, string $db_host = '127.0.0.1', string $db_port = '3306', string $db_user = 'root', string $db_pass = 'root', array $db_options) {
        $this->db_name = $db_name;
        $this->db_host = $db_host;
        $this->db_port = $db_port;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_options = $db_options;
    }

    /**
     * Retrieve instance of PDO
     * @return \PDO
     */
    public function getPDO(): \PDO {
        if (is_null($this->pdo)) {
            $this->pdo = new \PDO("mysql:host={$this->db_host}:{$this->db_port};dbname={$this->db_name}", $this->db_user, $this->db_pass, $this->db_options);
        }
        return $this->pdo;
    }

}