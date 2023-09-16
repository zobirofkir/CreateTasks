<?php
class PutTableTaskController
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function PutTask($id, $name, $email, $date, $status)
    {
        if ($_SERVER["REQUEST_METHOD"] === "PUT") {
            $data = file_get_contents("php://input");
            $array = json_decode($data, true);
    
            // Check if the JSON data was successfully decoded
            if ($array === null) {
                http_response_code(400);
                $errorResponse = ["error" => "Invalid JSON data"];
                header("Content-Type: application/json");
                echo json_encode($errorResponse);
                return;
            }
    
            // Sanitize and validate the input data
            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
            $name = filter_var($array["name"], FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($array["email"], FILTER_SANITIZE_EMAIL);
            $date = filter_var($array["date"], FILTER_SANITIZE_SPECIAL_CHARS);
            $status = filter_var($array["status"], FILTER_SANITIZE_SPECIAL_CHARS);
    
            // Check if all required fields are set
            if (empty($name) || empty($email) || empty($date) || empty($status)) {
                http_response_code(400);
                $errorResponse = ["error" => "Missing or empty fields"];
                header("Content-Type: application/json");
                echo json_encode($errorResponse);
                return;
            }
    
            $PutUsingModel = new PutTaskModel($this->database);
    
            // Check if the update was successful
            if ($PutUsingModel->updateTask($id, $name, $email, $date, $status)) {
                $response = ["success" => true];
            } else {
                $response = ["success" => false];
            }
    
            header("Content-Type: application/json");
            echo json_encode($response);
            return;
        }
    
        // Handle cases where the request method is not PUT
        http_response_code(400);
        $errorResponse = ["error" => "Invalid request method"];
        header("Content-Type: application/json");
        echo json_encode($errorResponse);
    }        
}
?>
