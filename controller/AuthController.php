<?php
require_once '../config/DataBase.php';
require_once '../models/User.php';
require_once '../models/Login.php';

session_start();

$database = new Database();
$db = $database->getConnection();

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'register':
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $user = new User($db);
            $user->name = $_POST['name'];
            $user->email = $_POST['email'];
            $user->passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $user->idGender = $_POST['idGender'];
            $user->idRole = $_POST['idRole'];

            if ($user->create()) {
                header("Location: ../views/login.php?msg=success");
                exit();
            } else {
                echo "Error: El usuario no pudo registrarse. El correo podría estar duplicado.";
            }
        }
        break;

    case 'login':
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = $_POST['email'];
            $pass  = $_POST['pass'];

            $auth = new Login($db);
            $userData = $auth->authenticate($email, $pass);

            if ($userData) {
                $_SESSION['user'] = $userData;
                header("Location: ../views/dashboard.php");
                exit;
            } else {
                header("Location: ../views/login.php?error=1");
                exit;
            }
        }
        break;

    case 'logout':
        $_SESSION = [];
        session_destroy();
        header("Location: ../views/home.php");
        exit;
        break;

    default:
        header("Location: ../views/home.php");
        break;
}