<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class PostTaskModel
{
    private $database;
 
    public function __construct($database)
    {
        $this->database = $database;
    }

    public function PostTask($name, $email, $date, $status, $user_id)
    {
        if (!isset($_SESSION["user_id"])) {
            return false; // Indicate unauthorized access
        }

        try {
            // Check if the user_id exists in the User table before inserting the task
            $checkUserSql = "SELECT COUNT(*) FROM User WHERE id = :user_id";
            $checkUserStmt = $this->database->prepare($checkUserSql);
            $checkUserStmt->bindParam(":user_id", $user_id);
            $checkUserStmt->execute();

            $userExists = $checkUserStmt->fetchColumn();

            if ($userExists) {
                $PostTaskSql = "INSERT INTO Tasks(name, email, date, status, user_id) VALUES (:name, :email, :date, :status, :user_id)";
                $PostParam = $this->database->prepare($PostTaskSql);
                $PostParam->bindParam(":name", $name);
                $PostParam->bindParam(":email", $email);
                $PostParam->bindParam(":date", $date);
                $PostParam->bindParam(":status", $status);
                $PostParam->bindParam(":user_id", $user_id);

                $success = $PostParam->execute();

                return $success;
            } else {
                // The provided user_id does not exist in the User table
                return false;
            }
        } catch (PDOException $e) {
            // Handle any database errors here
            // You can log the error or return a custom error message
            return false;
        }
    }
}
?>
