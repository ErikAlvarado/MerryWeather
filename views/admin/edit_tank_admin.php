<?php
session_start();
// Seguridad: solo admin
if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != 2) {
    header("Location: ../login.php"); exit;
}

require_once "../../controller/AdminController.php";
$adminCtrl = new AdminController();

// 1. Obtener datos del tanque a editar
$idTank = $_GET['idTank'] ?? null;
$tankData = null;

if ($idTank) {
    // Necesitamos un método en AdminController para obtener un solo tanque
    $tankData = $adminCtrl->getTankById($idTank);
}

if (!$tankData) {
    header("Location: admin_tanks.php?msg=NoEncontrado"); exit;
}

// 2. Procesar la actualización
if (isset($_POST['update_tank_admin'])) {
    $data = [
        'idTank' => $_POST['idTank'],
        'description' => $_POST['description'],
        'capacity' => $_POST['capacity'],
        'location' => $_POST['location']
    ];
    
    if ($adminCtrl->updateTankAnyUser($data)) {
        header("Location: admin_tanks.php?msg=updated");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <title>Admin - Editar Tanque</title>
</head>
<body>
    <?php include '../layout/header.php'; ?>
    <div class="container">
        <div class="login-container">
            <h3>Editar Tanque (Modo Admin)</h3>
            <p>Propietario: <strong><?php echo htmlspecialchars($tankData['owner']); ?></strong></p>
            
            <form method="POST">
                <input type="hidden" name="idTank" value="<?php echo $tankData['idTank']; ?>">
                
                <label>Descripción:</label>
                <input class="input" type="text" name="description" value="<?php echo htmlspecialchars($tankData['description']); ?>" required>
                
                <label>Capacidad (L):</label>
                <input class="input" type="number" name="capacity" value="<?php echo htmlspecialchars($tankData['capcity']); ?>" required>
                
                <label>Ubicación:</label>
                <input class="input" type="text" name="location" value="<?php echo htmlspecialchars($tankData['location']); ?>" required>
                
                <button type="submit" name="update_tank_admin" class="btn">Actualizar como Admin</button>
                <a href="admin_tanks.php" class="btn" style="text-decoration:none; display:block;">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>