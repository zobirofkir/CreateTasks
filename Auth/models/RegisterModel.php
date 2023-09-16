<?php
    class Register{
        private $database;

        public function __construct($database)
        {
            $this->database = $database;
        }

        public function CreateTable($username, $email, $password){
            $CreateRegisterTable = "CREATE TABLE User(id INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
                username VARCHAR(255) NOT NULL, 
                email VARCHAR (255) NOT NULL,
                password VARCHAR(255) NOT NULL
            )";

            $createTable = $this->database->prepare($CreateRegisterTable);
            $createTable->bindParam(":username", $username);
            $createTable->bindParam(":email", $email);
            $createTable->bindParam(":password", $password);
            $createTable->execute();
        }
    }
?>