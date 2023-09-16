<?php
class LoginModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function isEmailExists($email)
    {
        try {
            $query = "SELECT COUNT(*) FROM User WHERE email = :email";
            $stmt = $this->database->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            $count = $stmt->fetchColumn();

            return $count > 0;
        } catch (PDOException $e) {
            // Handle any database errors here
            // You can log the error or return a custom error message
            return false;
        }
    }

    public function verifyPassword($email, $password)
    {
        try {
            // Retrieve the user's hashed password from the database
            $query = "SELECT password FROM User WHERE email = :email";
            $stmt = $this->database->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            $hashedPassword = $stmt->fetchColumn();

            if (password_verify($password, $hashedPassword)) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>