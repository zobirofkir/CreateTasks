<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Start the session

class PostTaskController
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function PostTask()
    {
        header("Content-Type: application/json");

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = file_get_contents("php://input");
            $array = json_decode($data, true);

            if (
                isset($array["name"]) &&
                isset($array["email"]) &&
                isset($array["date"]) &&
                isset($array["status"])
            ) {
                $name = htmlspecialchars($array["name"], FILTER_SANITIZE_SPECIAL_CHARS);
                $email = filter_var($array["email"], FILTER_SANITIZE_EMAIL);
                $date = htmlspecialchars($array["date"], FILTER_SANITIZE_SPECIAL_CHARS);
                $status = htmlspecialchars($array["status"], FILTER_SANITIZE_SPECIAL_CHARS);

                // Check if "user_id" exists in the session before accessing it
                if (isset($_SESSION["user_id"])) {
                    $user_id = $_SESSION["user_id"];
                } else {
                    // Handle the case where "user_id" is not set in the session
                    http_response_code(401); // Unauthorized
                    $errorResponse = ["error" => "User not logged in"];
                    echo json_encode($errorResponse);
                    return;
                }

                // Assuming you have a PostTaskModel class
                $newPost = new PostTaskModel($this->database);

                $result = $newPost->PostTask($name, $email, $date, $status, $user_id);

                if ($result !== false) {
                    $response = ["success" => true];
                } else {
                    // Handle the case where PostTaskModel returns false
                    http_response_code(500); // Internal Server Error
                    $errorResponse = ["error" => "Failed to create task"];
                    echo json_encode($errorResponse);
                    return;
                }

                echo json_encode($response);
                return;
            }
        }

        // Handle cases where the request method is not POST or data is invalid
        http_response_code(400); // Set a 400 Bad Request HTTP status code
        $errorResponse = ["error" => "Invalid request"];
        echo json_encode($errorResponse);
    }
}
?>
