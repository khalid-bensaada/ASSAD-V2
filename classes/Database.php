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

        $db = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try {
            $this->pdo = new PDO($db, $this->username, $this->password, $options);
        } catch (PDOException $k) {
            die("Erreur de connexion : " . $k->getMessage());
        }
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}

?>