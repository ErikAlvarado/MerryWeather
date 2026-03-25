<?php
require_once __DIR__ . "/../controller/TanksController.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idTank = $_POST['idTank'] ?? null;
    $level  = $_POST['level'] ?? null;

    $controller = new TanksController();
    if ($controller->registerLevelLog($idTank, $level)) {
        echo "Log guardado";
    } else {
        http_response_code(500);
        echo "Error al guardar log";
    }
}