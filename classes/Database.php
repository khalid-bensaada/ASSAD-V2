<?php
class Database
{
    public $host;
    public $dbname;
    public $username;
    public $password;
    public $pdo;

    public function __construct($host = 'localhost', $dbname = 'zoo_assad', $username = 'root', $password = '')
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
        $conn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8";

        $error = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        try {
            $this->pdo = new PDO($conn, $this->username, $this->password, $error);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }    
    }

    public function getPdo(){
        return $this->pdo ;
    }
}

?>