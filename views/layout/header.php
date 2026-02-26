<header>
    <a href="/MerryWeather/views/home.php">
    <div class="logo">
    <img src="../assets/img/logo2.png" alt="Logo"  style="width:160px;">
    </div>
    </a>
    <nav>
        <div class="menu">
        <?php if (isset($_SESSION['user'])): ?>
            <a href="dashboard.php">Ver Tinacos</a>
            <a href="agregar_tinaco.php">Agregar Tinaco</a>
            <span class="user-name">Hola, <?php echo htmlspecialchars($_SESSION['user']['name']?? 'Invitado'); ?></span>
            <a href="../controller/AuthController.php?action=logout" class="btn-logout">Cerrar Sesión</a>
        <?php else: ?>
            <a href="login.php">Inicio de sesión</a>
            <a href="registro.php">Registrarse</a>
        <?php endif; ?>
        </div>
    </nav>
</header>