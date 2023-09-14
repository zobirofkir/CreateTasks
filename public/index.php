<?php
    $username = "admin";
    $password = "admin";
    
    try {
        $database = new PDO("mysql:host=localhost;dbname=Gestion;charset=utf8", $username, $password);
        // Set PDO error mode to exceptions for better error handling
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($database) {
            echo "Connected";
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        echo "Connection failed: " . $e->getMessage();
    }

    require_once "/var/www/html/GestionPhp/models/CreateTableTasksModel.php";
    $CreateTable = new CreateTableTasks($database);
    // $CreateTableExec = $CreateTable->CreateTable();

    // if ($_SERVER["REQUEST_URI"]==="/post" && $_SERVER["REQUEST_METHOD"] === "POST"){
    // }
?>
