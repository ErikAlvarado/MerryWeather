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
<div class="dashboard">
  <aside class="sidebar">
    <h2>MerryWeather</h2>
    <img src="../assets/img/tinaco.jpg" alt="tinaco" width="100">
    <button class="btn">Monitoreo</button>
    <button class="btn">Perfil</button>
    <a href="../controller/AuthController.php?action=logout"><button class="btn">Cerrar sesión</button></a>
  </aside>

  <main class="content">
    <p class="session">Sesión iniciada como: <?php echo $_SESSION['user']['name'] ?? 'Invitado'; ?></strong></p>

    <!-- <div class="form-container">
        <h3>Agregar Nuevo Tinaco</h3>
        <form method="POST">
            <input class="input" type="text" name="description" placeholder="Descripción (ej: Tinaco Azotea)" required>
            <input class="input" type="number" step="0.01" name="capacity" placeholder="Capacidad (Lts)" required>
            <input class="input" type="text" name="location" placeholder="Ubicación" required>
            <input class="input" type="date" name="installation_date" required>
            <button type="submit" name="add_tank" class="btn">Guardar Tinaco</button>
        </form>
    </div> -->

    <hr>

    <h3>TINACOS REGISTRADOS:</h3>
    <div class="tanks-grid" style="display: flex; gap: 20px; flex-wrap: wrap;">
        <?php if(empty($tanks)): ?>
            <p>No hay tinacos registrados.</p>
        <?php else: ?>
            <?php foreach($tanks as $tank): ?>
                <div class="tank-card" style="background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    <h4><?php echo htmlspecialchars($tank['description']); ?></h4>
                    <p><strong>Capacidad:</strong> <?php echo $tank['capcity']; ?> L</p>
                    <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($tank['location']); ?></p>
                    <p><strong>Instalado:</strong> <?php echo $tank['installation_date']; ?></p>
                    <div class="status-indicator" style="color: green;">Estado: Óptimo</div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
  </main>
</div>
</body>
</html>