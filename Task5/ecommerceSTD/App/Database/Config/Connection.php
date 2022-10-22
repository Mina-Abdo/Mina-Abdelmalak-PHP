<?php
namespace App\Database\Config;

class Connection {
    private $hostName = "localhost";
    private $hostUserName = "root";
    private $hostPassword = "";
    private $database = "ecommerce1";
    public \mysqli $conn;
    public function __construct() {
        $this->conn = new \mysqli($this->hostName,$this->hostUserName,$this->hostPassword,$this->database);

    }

    public function __destruct()
    {
        $this->conn->close();
    }
}