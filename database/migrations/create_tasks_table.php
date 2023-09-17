<?php
class CreateTableTasks
{
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

    public function createTable()
    {
        $createTableSql = "CREATE TABLE IF NOT EXISTS Tasks (
            id INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
            name VARCHAR(255) NOT NULL, 
            email VARCHAR(255) NOT NULL, 
            date DATE, 
            status VARCHAR(255) NOT NULL,
            user_id INT NOT NULL DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES User(id)
        )";

        try {
            $sendSql = $this->database->exec($createTableSql);
            if ($sendSql !== false) {
                echo "Tasks table created successfully.";
            } else {
                echo "Error creating Tasks table.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

// Create an instance of CreateTableTasks and establish a database connection
$Exec = new CreateTableTasks();
$Exec->createTable();
?>
