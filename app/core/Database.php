<?php
if (!class_exists('Database')) {
    class Database
    {
        private $host = 'localhost';
        private $username = 'root';
        private $password = '';
        private $database = 'hcshop';
        protected $conn;

        public function __construct()
        {
            $this->conn = new mysqli(
                $this->host,
                $this->username,
                $this->password,
                $this->database
            );

            if ($this->conn->connect_error) {
                die("Kết nối thất bại: " . $this->conn->connect_error);
            }
        }

        public function getConnection()
        {
            return $this->conn;
        }
    }
}
