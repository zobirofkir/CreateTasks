<?php
    class DeleteTasksController {
        private $database;

        public function __construct($database)
        {
            $this->database = $database;
        }


        public function DeleteTasksTableController($id){
            header("Content-Type: application/json");
        
            // Check if "user_id" exists in the session before accessing it
            if (isset($_SESSION["user_id"])) {
                $user_id = $_SESSION["user_id"];
            } else {
                // Handle the case where "user_id" is not set in the session
                http_response_code(401); // Unauthorized
                $errorResponse = ["error" => "User not logged in"];
                echo json_encode($errorResponse);
                return;
            }

            if ($_SERVER["REQUEST_METHOD"] === "DELETE"){
                if (isset($id) && !empty($id)) {
                    $Delete = new DeleteTaskTablesModel($this->database);
                    $success = $Delete->DeleteTaskModel($id);
                    if ($success){
                        $response = ["success" => true];
                        http_response_code(200); // OK
                    } else {
                        $response = ["error" => "Failed to delete task"];
                        http_response_code(500); // Internal Server Error
                    }
                } else {
                    http_response_code(400); // Bad Request
                    $response = ["error" => "Missing or empty 'id' parameter"];
                }
                
                echo json_encode($response);
                return;
            }
        }
    }
?>