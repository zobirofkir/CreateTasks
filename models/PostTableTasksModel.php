<?php
    class PostTaskModel{
        private $database;

        public function __construct($database){
            $this->database = $database;
        }

        public function PostTask(){
            $PostTaskSql = "INSERT INTO Tasks(username, email, date, status) VALUES (:username, :email, :date, :status)";
            $PostParam = $this->database->prepare($PostTaskSql);
            $PostParam->bindParam(":username", $username);
            $PostParam->bindParam(":email", $email);
            $PostParam->bindParam(":date", $date);
            $PostParam->bindParam(":status", $status);
            
            if ($PostParam->execute()){
                return json_encode(["success"=>true]);
            }else{
                return json_decode(["success"=>true]);
            }
        }
    }
?>