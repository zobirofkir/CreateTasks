<?php
class GetTableSql {
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function GetTableTask() {
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
        
        $GetTable = new GetTableTask($this->database);
        $data = $GetTable->GetDataTask();
        
        // Set the Content-Type header to indicate JSON response
        header("Content-Type: application/json");

        // Handle the JSON response
        echo json_encode($data);
    }
}
?>
