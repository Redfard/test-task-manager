<?php

namespace App;

class Database {

    protected $serverName = 'localhost';
    protected $userName = "root";
    protected $password = "";
    protected $dbName = "bee-jee-test";

    protected static $instance;
    protected $connection;


    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        if ($this->connection) {
            return $this->connection;
        }

        $mysqli = new \mysqli($this->serverName, $this->userName, $this->password, $this->dbName);

        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        $this->connection = $mysqli;

        return $this->connection;
    }
}