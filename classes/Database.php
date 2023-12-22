<?php
   require_once 'config.php';

   class Database {

        private static $instance = null;
        public $conn;


       
        private function __construct() {
            $this->conn = new PDO(DB_DNS, DB_USER, DB_PASS);
        }


        public static function getInstance(){
            if(!self::$instance){
                self::$instance = new Database();
            }
            return self::$instance;
        }


        public function getConnection(){
            return $this->conn;
        }


        public function sendQuerry($query){
            return $this->conn->query($query);
        }

        public function prepare($query){
            return $this->conn->prepare($query);
        }


    }











