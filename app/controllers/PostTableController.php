<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

                $newPost = new PostTaskModel($this->database);

                if ($newPost->PostTask($name, $email, $date, $status)) {
                    $response = ["success" => true];
                } else {
                    $response = ["success" => false];
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
