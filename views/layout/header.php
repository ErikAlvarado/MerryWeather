<header>
    <a href="../views/tanks.php" style="text-decoration: none;">
        <div class="logo">
            <img src="../assets/img/logoW.png" alt="Logo"  style="width:50px;">
            <p style="color:white; text-decoration: none; font-weight: bold;">MerryWeather</p>
        </div>
    </a>

    <button class="dropdownmenu" id="dropdownmenu">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <nav id="nav-menu">

        <!-- IMPLEMENTAR CUANDO SE PUEDA Y TENGA TIEMPO -->
        <div class="menu">
        <?php if (isset($_SESSION['user'])): 
        $currentPage = basename($_SERVER['PHP_SELF']);?>
        <?php if ($currentPage !== 'dashboard.php'): ?>
            <a href="dashboard.php">Inicio</a>
        <?php endif; ?>

        <?php if ($currentPage !== 'tanks.php'): ?>
            <a href="tanks.php">Lista Tinacos</a>
        <?php endif; ?>
        <?php if($currentPage !== 'createTanks.php'):?>
            <a href="createTanks.php">Agregar Tinaco</a>
        <?php endif;?>
            <a class="user-name">Hola, <?php echo htmlspecialchars($_SESSION['user']['name']?? 'Invitado'); ?></a>
            <a href="../controller/AuthController.php?action=logout" class="btn-logout">Cerrar Sesión</a>
        <?php else: ?>
            <a href="login.php">Inicio de sesión</a>
            <a href="register.php">Registrarse</a>
        <?php endif; ?>
        </div>
    </nav>
   <script src="../assets/js/dropdownmenu.js"></script>
</header>