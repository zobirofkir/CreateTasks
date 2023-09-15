<?php
    class GetTableTask{

        private $database;

        public function __construct($database)
        {
            $this->database = $database;
        }

        public function GetDataTask(){
            $SeleSql = "SELECT name, email FROM Tasks";
            $BindSql = $this->database->prepare($SeleSql);
            $BindSql->execute();
            $results = $BindSql->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }
    }

?>