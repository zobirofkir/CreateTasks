<?php
    class CreateTableTasks{
        private $database;
        
        public function __construct($database){
            $this->database = $database;
        }

        public function CreateTable(){
            $CreateTableSql = "CREATE TABLE Tasks(id INT PRIMARY KEY NOT NULL, 
            name VARCHAR(255) NOT NULL, 
            email VARCHAR(255) NOT NULL, 
            date DATE, 
            status VARCHAR(255) NOT NULL
            )";
            $SendSql = $this->database->prepare($CreateTableSql);
            $SendSql->execute();
        }
    }

?>