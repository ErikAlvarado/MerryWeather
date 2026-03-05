<?php
// Usamos __DIR__ para que PHP encuentre la ruta real en el servidor de AwardSpace
require_once __DIR__ . '/../config/DataBase.php';
require_once __DIR__ . '/../models/User.php';

session_start();

$database = new Database();
$db = $database->getConnection();

$action = $_GET['action'] ?? '';
$userModel = new User($db);

switch ($action) {
    case 'register':
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Asignamos los datos directamente al modelo
            $userModel->name = $_POST['name'];
            $userModel->email = $_POST['email'];
            $userModel->passwordHash = $_POST['password'];
            $userModel->idGender = $_POST['idGender'];
            $userModel->idRole = $_POST['idRole'];

            if ($userModel->create()) {
                // Redirección al login tras registro exitoso
                header("Location: ../views/login.php?msg=success");
                exit();
            } else {
                // Si falla (por ejemplo, email duplicado), regresamos con error
                header("Location: ../views/register.php?error=failed");
                exit();
            }
        }
        break;

    case 'login':
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = $_POST['email'];
            $pass  = $_POST['pass'];

            // El método authenticate ya fue migrado a MySQL con LIMIT 1
            $userData = $userModel->authenticate($email, $pass);

            if ($userData) {
                $_SESSION['user'] = $userData;
                header("Location: ../views/dashboard.php");
                exit();
            } else {
                header("Location: ../views/login.php?error=1");
                exit();
            }
        }
        break;

    case 'logout':
        // Limpiamos la sesión de forma segura
        session_unset();
        session_destroy();
        header("Location: ../views/home.php");
        exit();
        break;

    default:
        header("Location: ../views/home.php");
        exit();
        break;
}