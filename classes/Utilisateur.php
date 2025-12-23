<?php

require_once 'classes/Database.php';
$db = new Database();
$pdo = $db->getPdo();
class Utilisateur {
    private int $id;
    private string $username;
    private string $email;
    private string $user_role;
    private string $password_hash;
    private bool $actif;
    private bool $guide_approuve;

}
?>