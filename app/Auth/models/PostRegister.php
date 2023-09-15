<?php
    class PostRegister{
        private $database;

        public function __construct($database)
        {
            $this->database = $database;
        }

        public function postRegisterModel($username, $email, $password) {
            
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertIntoRegister = "INSERT INTO User (username, email, password) VALUES (:username, :email, :password)";
        
            $execUser = $this->database->prepare($insertIntoRegister);
        
            $execUser->bindParam(":username", $username);
            $execUser->bindParam(":email", $email);
            $execUser->bindParam(":password", $hashedPassword);
        
            $execUser->execute();
        }
    }
    
?>