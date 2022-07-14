<?php
    class DB
    {
        private $_connection;
        private static $_instance; 
        public $_host = 'localhost';
        public $_username = 'u658453311_fire';
        public $_password = 'fiream2014';
        public $_database = 'u658453311_fire';
    
        public static function getInstance()
        {
            if (!self::$_instance) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }
    
        private function __construct()
        {   
            try {
                $this->_connection = new PDO("mysql:host=$this->_host;dbname=$this->_database;charset=utf8", $this->_username, $this->_password); 
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    
        private function __clone()
        {
        }
        
        public function setConfig($data){

            $this->_host = $data['host'];
            $this->_password = $data['password'];
            $this->_username = $data['username'];
            $this->_database = $data['database'];

        }

        public function getConnection()
        {
            return $this->_connection;
        }
    }
    
    class Stmt extends DB {
        public static function query($sql) {
            return parent::getInstance()->getConnection()->query($sql);
            }
        }         
        
        $db = DB::getInstance();
        $conn = $db->getConnection();   


?> 