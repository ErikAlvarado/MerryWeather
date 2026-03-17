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
$controller->deleteTank($user['idUser']);
$controller->updateTank($user['idUser']);
$tanks = $controller->listUserTanks($user['idUser']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tinacos</title>
    <link rel="stylesheet" href="../assets/css/style.css">

</head>
<body>
<?php
include 'layout/header.php';
?>
<div class="tanks">
  <main class="content">

    <hr>

    <h3>TINACOS REGISTRADOS:</h3>
    <div class="tanks-grid">
        <?php if(empty($tanks)): ?>
            <p>No hay tinacos registrados.</p>
        <?php else: ?>
            <?php foreach($tanks as $tank): ?>
                <div class="tank-card" style="background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    <div class="tank-info">
                    <img src="" alt="">
                        <h4><?php echo htmlspecialchars($tank['description']); ?></h4>
                        <p><strong>Capacidad:</strong> <?php echo $tank['capcity']; ?> L</p>
                        <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($tank['location']); ?></p>
                        <div class="status-indicator" style="color: green;">Estado: Óptimo</div>
                    </div>
                    <div class="dropdown">
                        <button class="dropbtn" onclick="toggleDropdown(this)">Opciones</button>
                        <div class="dropdown-content">
                            <a href="update_tank.php?idTank=<?php echo $tank['idTank']; ?>&idUser=<?php echo $user['idUser']; ?>">Editar</a>
                            
                            <form action="tanks.php" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este tanque?');">
                                <input type="hidden" name="idTank" value="<?php echo $tank['idTank']; ?>">
                                <button type="submit" name="delete" class="btn-delete">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
  </main>
</div>
<script>
const tanksfrom = <?php echo json_encode($tanks); ?>;
</script>
<script src="/MerryWeather/assets/js/tanksdropdown.js"></script>
<script src="../assets/js/indexed_tanks.js"></script>
</body>
</html>
