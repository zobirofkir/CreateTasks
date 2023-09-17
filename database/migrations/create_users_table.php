<?php
class Register{
    private $database;

    // Moved the database connection code to the constructor
    public function __construct()
    {
        $username = "admin";
        $password = "admin";

        try {
            // Attempt to establish a database connection
            $this->database = new PDO("mysql:host=localhost;dbname=Gestion;charset=utf8", $username, $password);
            // Set PDO error mode to exceptions for better error handling
            $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Handle database connection errors
            echo "Connection failed: " . $e->getMessage();
            exit(); // Terminate the script if there's a database connection error
        }
    }

    public function CreateTable(){
        $CreateRegisterTable = "CREATE TABLE IF NOT EXISTS User (
            id INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
            username VARCHAR(255) NOT NULL, 
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL
        )";

        try {
            $createTable = $this->database->exec($CreateRegisterTable);
            if ($createTable !== false) {
                echo "User table created successfully.";
            } else {
                echo "Error creating User table.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

$Execute = new Register();
$Execute->CreateTable();
?>
