<?php

class GetTableTask
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function GetDataTask()
    {
        // Check if the user is authorized (e.g., by checking if a user-specific session variable exists)
        if (!isset($_SESSION["user_id"])) {
            http_response_code(401); // Unauthorized
            echo json_encode(["error" => "Unauthorized"]);
            return;
        }

        $selectSql = "SELECT name, email FROM Tasks";
        $stmt = $this->database->prepare($selectSql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
}
?>
