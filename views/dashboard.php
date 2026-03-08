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
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Monitoreo - MerryWeather</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php
include 'layout/header.php';
?>

</body>
</html>


