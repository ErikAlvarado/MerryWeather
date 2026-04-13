<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != 2) {
    header("Location: ../login.php?error=unauthorized");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../layout/header.php'; ?>
    
    <main class="content">
        <h1>Bienvenido Administrador: <?php echo htmlspecialchars($_SESSION['user']['name']); ?></h1>
        <p>Seleccione una categoría para gestionar:</p>
        
        <div class="buttons-container">
            <a href="admin_users.php" class="btn-modal">Gestionar Usuarios</a>
            <a href="admin_tanks.php" class="btn-modal">Gestionar todos los Tanques</a>
        </div>
    </main>
</body>
</html>