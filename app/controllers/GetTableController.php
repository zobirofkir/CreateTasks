<?php
class GetTableSql {
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function GetTableTask() {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $GetTable = new GetTableTask($this->database);
            $data = $GetTable->GetDataTask();
            
            // Set the Content-Type header to indicate JSON response
            header("Content-Type: application/json");

            // Handle the JSON response
            echo json_encode($data);
            return;
        }
    }
}
?>