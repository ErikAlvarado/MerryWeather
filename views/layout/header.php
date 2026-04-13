<?php
$isInAdmin = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false);
$pathPrefix = $isInAdmin ? '../' : ''; 
?>

<header>
    <a href="<?php echo $isAdmin ? $pathPrefix . 'admin/admin.php' : $pathPrefix . 'tanks.php'; ?>" style="text-decoration: none;">
        <div class="logo">
            <img src="<?php echo $pathPrefix; ?>../assets/img/logoW.png" alt="Logo" style="width:50px;">
            <p style="color:white; text-decoration: none; font-weight: bold;">MerryWeather</p>
        </div>
    </a>

    <button class="dropdownmenu" id="dropdownmenu">
        <span></span><span></span><span></span>
    </button>

    <nav id="nav-menu">
        <div class="menu">
        <?php if (isset($_SESSION['user'])): 
            $currentPage = basename($_SERVER['PHP_SELF']);
            $isAdmin = ($_SESSION['user']['idRole'] == 2);
        ?>
            
            <?php if ($isAdmin): ?>
                <a href="<?php echo $pathPrefix; ?>admin/admin.php">Panel Admin</a>
                <a href="<?php echo $pathPrefix; ?>admin/admin_users.php">Gestionar Usuarios</a>
                <a href="<?php echo $pathPrefix; ?>admin/admin_tanks.php">Tanques Globales</a>
            <?php else: ?>
                <?php if ($currentPage !== 'dashboard.php'): ?>
                    <a href="<?php echo $pathPrefix; ?>dashboard.php">Inicio</a>
                <?php endif; ?>

                <?php if ($currentPage !== 'tanks.php'): ?>
                    <a href="<?php echo $pathPrefix; ?>tanks.php">Lista Tinacos</a>
                <?php endif; ?>

                <?php if($currentPage !== 'createTanks.php'):?>
                    <a href="<?php echo $pathPrefix; ?>createTanks.php">Agregar Tinaco</a>
                <?php endif;?>
            <?php endif; ?>

            <a class="user-name">Hola, <?php echo htmlspecialchars($_SESSION['user']['name'] ?? 'Invitado'); ?></a>
            
            <a href="<?php echo $pathPrefix; ?>../controller/AuthController.php?action=logout" class="btn-logout">Cerrar Sesión</a>
            
        <?php else: ?>
            <a href="<?php echo $pathPrefix; ?>login.php">Inicio de sesión</a>
            <a href="<?php echo $pathPrefix; ?>register.php">Registrarse</a>
        <?php endif; ?>
        </div>
    </nav>
    <script src="<?php echo $pathPrefix; ?>../assets/js/dropdownmenu.js"></script>
</header>