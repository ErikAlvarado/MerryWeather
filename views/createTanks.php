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

$controller->createTank($user['idUser']);
$tanks = $controller->listUserTanks($user['idUser']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Registro</title>
</head>
<body>
<?php include 'layout/header.php'; ?>
<div class="container">
    <div class="login-container">
        <h3>Agregar Nuevo Tinaco</h3>
        <form method="POST">
            <input class="input" type="text" name="description" placeholder="Descripción (ej: Tinaco Azotea)" required>
            <input class="input" type="number" step="0.01" name="capacity" placeholder="Capacidad (Lts)" required>
            <input class="input" type="text" name="location" placeholder="Ubicación" required>
            <input class="input" type="date" name="installation_date" required>
            <button type="submit" name="add_tank" class="btn">Guardar Tinaco</button>
        </form>
    </div>
</main>
</body>
</html>