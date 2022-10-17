<?php
namespace App\Database\Config;
class Connection {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "ecommerce1";
    public \mysqli $connect;
    public function __construct()
    {
        $this->connect = new \mysqli($this->servername , $this->username , $this->password , $this->database);
        // if($this->connect->connect_error){
        //     die("connection failed: " . $this->connect->connect_error);
        // }
    }

    public function __destruct()
    {
        $this->connect->close();
    }
}
