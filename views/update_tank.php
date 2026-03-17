<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require_once "../controller/TanksController.php";
$controller = new TanksController();
$user = $_SESSION['user'];
$userName = $_SESSION['user']['name'];

$controller->updateTank($user['idUser']);
$idTank = $_GET['idTank'] ?? $_POST['idTank'] ?? '';
$idUser = $_GET['idUser'] ?? $_POST['idTank'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>update_tank</title>
</head>
<body>
    <?php include 'layout/header.php'; ?>
        <div class="container">
            <div class="login-container">
                <h3>Actualiza tu tinaco</h3>
                <form method="POST">
                    <input type="hidden" name="idTank" value="<?php echo htmlspecialchars($idTank); ?>">
                    <input type="hidden" name="idUser" value="<?php echo htmlspecialchars($isUser); ?>">
                    <input class="input" type="text" name="description" placeholder="" required>
                    <input class="input" type="number" step="0.01" name="capacity" placeholder="" required>
                    <input class="input" type="text" name="location" placeholder="" required>
                    <button type="submit" name="update_tank" class="btn">Guardar Tinaco</button>
                </form>
            </div>
    </body>
</html>