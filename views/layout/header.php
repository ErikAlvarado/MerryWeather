<header>
    <a href="/MerryWeather/views/home.php" style="text-decoration: none;">
    <div class="logo">
    <img src="../assets/img/logoW.png" alt="Logo"  style="width:70px;">
    <p style="color:white; text-decoration: none; font-weight: bold;">MerryWeather</p>
    </div>
    </a>
    
    <nav>
        <div class="menu">
        <?php if (isset($_SESSION['user'])): ?>
            <a href="dashboard.php">Ver Tinacos</a>
            <a href="createTanks.php">Agregar Tinaco</a>
            <a class="user-name">Hola, <?php echo htmlspecialchars($_SESSION['user']['name']?? 'Invitado'); ?></a>
            <a href="../controller/AuthController.php?action=logout" class="btn-logout">Cerrar Sesión</a>
        <?php else: ?>
            <a href="login.php">Inicio de sesión</a>
            <a href="registro.php">Registrarse</a>
        <?php endif; ?>
        </div>
    </nav>
</header>