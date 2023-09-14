<?php
    require_once "/var/www/html/GestionPhp/models/PostTableTasksModel.php";
    class PostTaskController{
        private $database;

        public function __construct($database){
            $this->database = $database;
        }

        public function PostTask(){
            if ($_SERVER["REQUEST_METHOD"] === "POST"){
                $data = file_get_contents("php://input");
                $array = json_encode($data, true);
                if (isset($array["username"]) &&
                isset($array["email"])&&
                isset($array["date"]) &&
                isset($array["status"])
                )
                {
                    
                }
            }
        }
    }
?>