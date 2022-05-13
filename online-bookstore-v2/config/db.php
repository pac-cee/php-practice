<?php
class Database {
    private $host     = "127.0.0.1";
    private $port     = 3306;
    private $db_name  = "bookapp";
    private $username = "root";
    private $password = "";

    public  $conn;

    public function __construct() {
        $this->conn = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->db_name,
            $this->port
        );
        if ($this->conn->connect_error) {
