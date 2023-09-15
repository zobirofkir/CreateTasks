<?php
class CreateTableTasks
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function createTable()
    {
        $createTableSql = "CREATE TABLE IF NOT EXISTS Tasks (
            id INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
            name VARCHAR(255) NOT NULL, 
            email VARCHAR(255) NOT NULL, 
            date DATE, 
            status VARCHAR(255) NOT NULL,
            user_id INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id)
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
?>
