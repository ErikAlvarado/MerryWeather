<?php
session_start();

require_once "../config/DataBase.php";
require_once "../models/login.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST['email'];
    $pass  = $_POST['pass'];

    $db = new DataBase();
    $conn = $db->getConnection();

    $login = new Login($conn);
    $user = $login->authenticate($email, $pass);

    if ($user) {
        $_SESSION['user'] = $user;   // ← SESIÓN CREADA
        header("Location: ../views/index.php");
        exit;
    } else {
        header("Location: ../views/login.php?error=1");
        exit;
    }
}