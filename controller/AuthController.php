<?php

require_once '../config/DataBase.php';
require_once '../models/User.php';

session_start();

$action = $_GET['action'] ?? ''; 

if ($action === 'register') {
    $database = new Database();
    $DataBase = $database->getConnection();
    $user = new User($DataBase);

    $user->name = $_POST['name'];
    $user->email = $_POST['email'];
    $user->passwordHash = $_POST['passwordHash'];
    $user->idGender = $_POST['idGender'];
    $user->idRole = $_POST['idRole'];

    if($user->create()) {
        header("Location: ../views/login.php?msg=success");
        exit(); 
    } else {    
        echo "The user could not be registered. The email address may already exist.";
    }
}
