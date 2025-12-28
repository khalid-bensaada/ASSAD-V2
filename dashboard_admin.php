<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
?>
