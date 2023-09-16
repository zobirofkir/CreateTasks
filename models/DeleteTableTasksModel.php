<?php
class DeleteTaskTablesModel {
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function DeleteTaskModel($id) {
        if (!isset($_SESSION["user_id"])) {
            http_response_code(401); // Unauthorized
            echo json_encode(["error" => "Unauthorized"]);
            return;
        }

        try {
            $DeletTask = "DELETE FROM Tasks WHERE id = :id";
            $DeletTaskParam = $this->database->prepare($DeletTask);
            $DeletTaskParam->bindParam(":id", $id, PDO::PARAM_INT); 
            
            return $DeletTaskParam->execute();
        } catch (PDOException $e) {
            return false . $e->getMessage();
        }
    }
}

?>