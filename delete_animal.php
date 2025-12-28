<?php
session_start();
require_once 'Database.php';
require_once 'Animale.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: admin_animaux.php');
    exit;
}

$id = intval($_GET['id']);


$db = new Database();
$animal = new Animale();
$animal->pdo = $db->getPdo();


$animal->setAid($id);


$animal->deleteAnimal(); 

?>