<?php
class PostRegisterModel
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

            return $count > 0; // Return true if email exists, false otherwise
        } catch (PDOException $e) {
            // Handle any database errors here
            // You can log the error or return a custom error message
            return false;
        }
    }

    public function registerUser($username, $email, $password)
    {
        // Check if the email already exists
        if ($this->isEmailExists($email)) {
            return false; // Email already exists, registration failed
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Use try-catch for error handling
        try {
            // SQL query with placeholders
            $insertIntoRegister = "INSERT INTO User (username, email, password) VALUES (:username, :email, :password)";

            // Prepare the query
            $execUser = $this->database->prepare($insertIntoRegister);

            // Bind parameters
            $execUser->bindParam(":username", $username);
            $execUser->bindParam(":email", $email);
            $execUser->bindParam(":password", $hashedPassword);

            // Execute the query
            $execUser->execute();

            // Check for errors
            if ($execUser->rowCount() > 0) {
                // Retrieve the newly inserted user's ID
                $user_id = $this->database->lastInsertId();

                // Set the user_id in the session
                $_SESSION["user_id"] = $user_id;

                return true; // Registration successful
            } else {
                return false; // Registration failed
            }
        } catch (PDOException $e) {
            // Handle any database errors here
            // You can log the error or return a custom error message
            return false;
        }
    }
}


?>
