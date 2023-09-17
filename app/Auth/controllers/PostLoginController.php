<?php
class LoginController
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function loginUser()
    {
        session_start(); // Initialize the session within the method
        
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = file_get_contents("php://input");
            $array = json_decode($data, true);

            if (isset($array["email"]) && isset($array["password"])) {
                $email = htmlspecialchars($array["email"], FILTER_SANITIZE_EMAIL);
                $password = htmlspecialchars($array["password"], FILTER_SANITIZE_SPECIAL_CHARS);

                $userLogin = new LoginModel($this->database);
                if ($userLogin->isEmailExists($email)) {
                    if ($userLogin->verifyPassword($email, $password)) {
                        // Password is correct, perform the redirect
                        $_SESSION['authenticated'] = true; // Set a session variable for authentication
                        header("Location: /GestionPhp/public/index.php/get/task");
                        exit(); // Exit to prevent further execution
                    } else {
                        // Incorrect password, set appropriate status code
                        http_response_code(401); // Unauthorized
                        $response = ["success" => false, "error" => "Incorrect password"];
                    }
                } else {
                    // Email not found, set appropriate status code
                    http_response_code(404); // Not Found
                    $response = ["success" => false, "error" => "Email not found"];
                }

                // Set response content type to JSON
                header('Content-Type: application/json');
                // Send the JSON response
                echo json_encode($response);
            }
        }
    }
}

?>