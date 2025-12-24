<?php

require_once 'classes/Database.php';

class Utilisateur
{
    private int $id;
    private string $username;
    private string $email;
    private string $user_role;
    private string $password_hash;
    private bool $actif;
    private bool $guide_approuve;

    private $pdo;

    // make objects for the attributs i make 
    public function __construct(string $username = "", string $email = "", string $user_role = "", string $password_hash = "", bool $actif = "", bool $guide_approuve = "")
    {

        $this->username = $username;
        $this->email = $email;
        $this->user_role = $user_role;
        $this->password_hash = $password_hash;
        $this->actif = $actif;
        $this->guide_approuve = $guide_approuve;
    }

    //Get for read the value

    public function getid(): int
    {
        return $this->id;
    }

    // get object of username in function 
    public function getusername(): string
    {
        return $this->username;
    }

    // get object of email in function 
    public function getemail(): string
    {
        return $this->email;
    }
    // get object of user_role in function 
    public function getrole(): string
    {
        return $this->user_role;
    }

    // get object of password_hash in function 
    public function getpassword(): string
    {
        return $this->password_hash;
    }

    // get object of actif in function 
    public function getactif(): bool
    {
        return $this->actif;
    }

    // get object of guide_approuve in function 
    public function getapprouve(): bool
    {
        return $this->guide_approuve;
    }


}
?>