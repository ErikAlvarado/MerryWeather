    <?php
    require_once '../config/DataBase.php';
    require_once '../models/User.php';

    session_start();

    $database = new Database();
    $db = $database->getConnection();

    $action = $_GET['action'] ?? '';
    $userModel = new User($db);

    switch ($action) {
        case 'register':
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $userModel = new User($db);
                $userModel->name = $_POST['name'];
                $userModel->email = $_POST['email'];
                $userModel->passwordHash = $_POST['password'];
                $userModel->idGender = $_POST['idGender'];
                $userModel->idRole = $_POST['idRole'];

                if ($userModel->create()) {
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

                $userModel = new User($db);
                $userData = $userModel->authenticate($email, $pass);

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