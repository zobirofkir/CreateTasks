<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class PostTaskModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function PostTask($name, $email, $date, $status)
    {
        $PostTaskSql = "INSERT INTO Tasks(name, email, date, status) VALUES (:name, :email, :date, :status)";
        $PostParam = $this->database->prepare($PostTaskSql);
        $PostParam->bindParam(":name", $name);
        $PostParam->bindParam(":email", $email);
        $PostParam->bindParam(":date", $date);
        $PostParam->bindParam(":status", $status);

        $success = $PostParam->execute();

        return $success;
    }
}
?>
