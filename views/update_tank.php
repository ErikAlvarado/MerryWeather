<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require_once "../controller/TanksController.php";
$controller = new TanksController();
$user = $_SESSION['user'];

$controller->updateTank($user['idUser']);


$idTank = $_GET['idTank'] ?? null;
$idUser = $_GET['idUser'] ?? null;

$tankData = null;
if ($idTank) {
    $allTanks = $controller->listUserTanks($user['idUser']);
    foreach ($allTanks as $t) {
        if ($t['idTank'] == $idTank) {
            $tankData = $t;
            break;
        }
    }
}

// Si no se encuentra el tanque, redirigir
if (!$tankData) {
    header("Location: tanks.php?msg=Tanque no encontrado");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Actualizar Tinaco</title>
</head>
<body>
    <?php include 'layout/header.php'; ?>
    
    <div class="container">
        <div class="login-container">
            <h3>Actualiza tu tinaco</h3>
            <form method="POST" action="update_tank.php">
                <input type="hidden" name="idTank" value="<?php echo htmlspecialchars($idTank); ?>">
                
                <label>Descripción:</label>
                <input class="input" type="text" name="description" 
                       value="<?php echo htmlspecialchars($tankData['description']); ?>" required>
                
                <label>Capacidad (Liters):</label>
                <input class="input" type="number" step="0.01" name="capacity" 
                       value="<?php echo htmlspecialchars($tankData['capcity']); ?>" required>
                
                <label>Ubicación:</label>
                <input class="input" type="text" name="location" 
                       placeholder="<?php echo htmlspecialchars($tankData['location']); ?>"
                       value="<?php echo htmlspecialchars($tankData['location']); ?>" required>
                
                <button type="submit" name="update_tank" class="btn">Guardar Cambios</button>
                <button href="tanks.php" class="btn">Cancelar</button>
            </form>
        </div>
    </div>
</body>
</html>