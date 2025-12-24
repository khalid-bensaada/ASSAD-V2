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


}
?>