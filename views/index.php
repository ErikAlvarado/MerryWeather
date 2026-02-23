<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require_once "../controller/TanksController.php";
$controller = new TanksController();
$user = $_SESSION['user'];

$controller->createTank($user['idUser']);
$tanks = $controller->listUserTanks($user['idUser']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Monitoreo</title>
  <link rel="stylesheet" href="style2.css">
</head>
<body>
<div class="dashboard">
  <aside class="sidebar">
    <h2>MerryWeather</h2>
    <img src="../img/tinaco.jpg" alt="tinaco" width="100">
    <button class="btn green">Monitoreo</button>
    <button class="btn gray">Perfil</button>
    <a href="../controller/logout.php"><button class="btn red">Cerrar sesión</button></a>
  </aside>

  <main class="content">
    <p class="session">Sesión iniciada como: <strong><?php echo $_SESSION['user']; ?></strong></p>

    <div class="form-container">
        <h3>Agregar Nuevo Tinaco</h3>
        <form method="POST">
            <input type="text" name="description" placeholder="Descripción (ej: Tinaco Azotea)" required>
            <input type="number" step="0.01" name="capacity" placeholder="Capacidad (Lts)" required>
            <input type="text" name="location" placeholder="Ubicación" required>
            <input type="date" name="installation_date" required>
            <button type="submit" name="add_tank" class="btn green">Guardar Tinaco</button>
        </form>
    </div>

    <hr>

    <h3>TINACOS REGISTRADOS:</h3>
    <div class="tanks-grid">
        <?php if(empty($tanks)): ?>
            <p>No hay tinacos registrados.</p>
        <?php else: ?>
            <?php foreach($tanks as $tank): ?>
                <div class="tank-card">
                    <h4><?php echo htmlspecialchars($tank['description']); ?></h4>
                    <p><strong>Capacidad:</strong> <?php echo $tank['capcity']; ?> L</p>
                    <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($tank['location']); ?></p>
                    <p><strong>Instalado:</strong> <?php echo $tank['installation_date']; ?></p>
                    <div class="status-indicator">Estado: Óptimo</div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
  </main>
</div>
</body>
</html>