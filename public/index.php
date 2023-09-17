<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);




$username = "admin";
$password = "admin";

try {
    // Attempt to establish a database connection
    $database = new PDO("mysql:host=localhost;dbname=Gestion;charset=utf8", $username, $password);
    // Set PDO error mode to exceptions for better error handling
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Handle database connection errors
    echo "Connection failed: " . $e->getMessage();
    exit(); // Terminate the script if there's a database connection error
}

// Set the Content-Type header to indicate JSON response
header("Content-Type: application/json");

require_once "/var/www/html/GestionPhp/app/models/PostTableTasksModel.php";
require_once "/var/www/html/GestionPhp/app/controllers/PostTableController.php";

require_once "/var/www/html/GestionPhp/app/models/GetTableTasks.php";
require_once "/var/www/html/GestionPhp/app/controllers/GetTableController.php";

require_once "/var/www/html/GestionPhp/app/models/PutTableTasksModel.php";
require_once "/var/www/html/GestionPhp/app/controllers/PutTableController.php";

require_once "/var/www/html/GestionPhp/app/models/DeleteTableTasksModel.php";
require_once "/var/www/html/GestionPhp/app/controllers/DeleteController.php";

// Authentication

require_once "/var/www/html/GestionPhp/app/Auth/models/PostRegister.php";
require_once "/var/www/html/GestionPhp/app/Auth/controllers/PostRegisterController.php";

require_once "/var/www/html/GestionPhp/app/Auth/models/PostLogin.php";
require_once "/var/www/html/GestionPhp/app/Auth/controllers/PostLoginController.php";

if ($_SERVER["REQUEST_URI"] === "/GestionPhp/public/index.php/post" && $_SERVER["REQUEST_METHOD"] === "POST") {
    header("Content-Type: application/json");

    $PostData = new PostTaskController($database);
    $result = $PostData->PostTask();

    // Check if $result is not null and is an array
    if (is_array($result) && isset($result["success"])) {
        if ($result["success"] === true) {
            $response = ["success" => true];
        } else {
            $response = ["success" => false];
        }
    } else {
        // Handle the case where $result is null or not an array
        $response = ["success" => false];
    }

    // Send the JSON response
    echo json_encode($response);
}



if ($_SERVER["REQUEST_URI"] === '/GestionPhp/public/index.php/get/task' && $_SERVER["REQUEST_METHOD"] === "GET") {
    // Include necessary dependencies here, such as the database connection and the GetTableSql class.
    
    $GetTableSql = new GetTableSql($database);
    $GetTableSql->GetTableTask();
}


if ($_SERVER["REQUEST_URI"] === "/GestionPhp/public/index.php/update" && $_SERVER["REQUEST_METHOD"] === "PUT") {
    header("Content-Type: application/json");

    // Assuming you receive the data as JSON in the request body
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    // Check if the required data fields are present in the JSON data
    if (isset($data["id"]) && isset($data["name"]) && isset($data["email"]) && isset($data["date"]) && isset($data["status"])) {
        // Assign the values from JSON data to variables
        $id = $data["id"];
        $name = $data["name"];
        $email = $data["email"];
        $date = $data["date"];
        $status = $data["status"];

        // Create an instance of the PutTableTaskController
        $PutData = new PutTableTaskController($database);
        
        // Call the PutTask method to handle the PUT request
        $PutData->PutTask($id, $name, $email, $date, $status);
    } else {
        // Handle the case where required data fields are missing
        http_response_code(400); // Bad Request
        $error_response = ["error" => "Missing or invalid data fields"];
        echo json_encode($error_response);
    }
}

if ($_SERVER["REQUEST_URI"] === "/GestionPhp/public/index.php/delete" && $_SERVER["REQUEST_METHOD"] === "DELETE") {
    header("Content-Type: application/json");

    $DeleteParam = new DeleteTasksController($database);
    $DeleteParam->DeleteTasksTableController($id);
}

if ($_SERVER["REQUEST_URI"] === "/GestionPhp/public/index.php/user/register" && $_SERVER["REQUEST_METHOD"] === "POST") {
    header("Content-Type: application/json");


    $RegisterPost = new PostRegisterController($database);
    $RegisterPost->PostRegister();
}

if ($_SERVER["REQUEST_URI"] === "/GestionPhp/public/index.php/user/login" && $_SERVER["REQUEST_METHOD"] === "POST") {
    header("Content-Type: application/json");


    $RegisterPost = new LoginController($database);
    $RegisterPost->loginUser();
}


?>
