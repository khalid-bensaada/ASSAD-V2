<?php
class Database
{
    public $host;
    public $dbname;
    public $username;
    public $password;
    public $pdo;

    public function __construct(){
        $this->host = "localehost";
        $this->dbname = "zoo_assad";
        $this->username = "root";
        $this->password = "";
        
    }

}


?>