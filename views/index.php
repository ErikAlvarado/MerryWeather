<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
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
    <img src="../img/tinaco.jpg" alt="tinaco">
    <button class="btn green">Monitoreo</button>
    <button class="btn gray">Perfil</button>
    <a href="../controller/logout.php">
    <button class="btn red">Cerrar sesion</button>
    </a>
  </aside>
  <!-- CONTENIDO -->
  <main class="content">
    <p class="session">Sesión iniciada como: <strong>Marilu</strong></p>

    <h3>ESTADO:</h3>
  </main>

</div>
</body>
</html>