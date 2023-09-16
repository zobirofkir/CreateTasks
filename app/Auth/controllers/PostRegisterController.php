<?php
class PostRegisterController
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function PostRegister()
    {
        // session_start(); // Start the session

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Get JSON data from the request body
            $data = file_get_contents("php://input");
            $array = json_decode($data, true);

            // Check if the required fields are set in the JSON data
            if (isset($array["username"]) && isset($array["email"]) && isset($array["password"])) {
                $username = htmlspecialchars($array["username"], FILTER_SANITIZE_SPECIAL_CHARS);
                $email = htmlspecialchars($array["email"], FILTER_SANITIZE_EMAIL);
                $password = htmlspecialchars($array["password"], FILTER_SANITIZE_SPECIAL_CHARS);

                try {
                    // Check if the email is valid
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        http_response_code(400); // Set HTTP status code to 400 (Bad Request)
                        echo json_encode(["success" => false, "error" => "Invalid email format"]);
                        return;
                    }

                    // Create an instance of PostRegisterModel
                    $postRegisterModel = new PostRegisterModel($this->database);

                    // Call the postRegisterModel method to handle registration
                    $user_id = $postRegisterModel->registerUser($username, $email, $password);

                    if ($user_id !== false) {
                        // Registration was successful, store user_id in the session
                        $_SESSION["user_id"] = $user_id;
                        $response = ["success" => true];
                        http_response_code(200); // Set HTTP status code to 200 (OK)
                    } else {
                        $response = ["success" => false];
                        http_response_code(400); // Set HTTP status code to 400 (Bad Request)
                    }
                    header('Content-Type: application/json'); // Set response content type to JSON
                    echo json_encode($response);
                    return;
                } catch (PDOException $e) {
                    // Handle any database errors here
                    // Log the error or return a custom error message
                    http_response_code(500); // Set HTTP status code to 500 (Internal Server Error)
                    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
                    return;
                }
            }
        }
        
        // Handle invalid or missing POST data
        http_response_code(400); // Set HTTP status code to 400 (Bad Request)
        echo json_encode(["error" => "Invalid data"]);
    }
}
?>
