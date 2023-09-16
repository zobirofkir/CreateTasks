<?php
class PutTaskModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function updateTask($id, $name, $email, $date, $status)
    {
        if (!isset($_SESSION["user_id"])) {
            http_response_code(401); // Unauthorized
            echo json_encode(["error" => "Unauthorized"]);
            return;
        }

        $updateQuery = "UPDATE Tasks SET name = :name, email = :email, date = :date, status = :status WHERE id = :id";
        $updateStatement = $this->database->prepare($updateQuery);
        $updateStatement->bindParam(":id", $id);
        $updateStatement->bindParam(":name", $name);
        $updateStatement->bindParam(":email", $email);
        $updateStatement->bindParam(":date", $date);
        $updateStatement->bindParam(":status", $status);

        return $updateStatement->execute();
    }
}


?>