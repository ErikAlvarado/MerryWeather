<!DOCTYPE html>
<html lang="es"> <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Login - Merryweather</title>
</head>
<body>

<?php 
    // Usamos include normal; si layout está en la misma carpeta que login.php, 
    // la ruta 'layout/header.php' es correcta.
    include 'layout/header.php'; 
?>

<div class="container">
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        
        <form method="POST" action="../controller/AuthController.php?action=login" class="login-register">
            <input class="input" type="email" name="email" placeholder="Correo electrónico" required>
            <input class="input" type="password" name="pass" placeholder="Contraseña" required>
            <button type="submit" class="btn">Ingresar</button>
        </form>
        
        <?php if(isset($_GET['error'])): ?>
            <p style="color: #ff4d4d; text-align: center; margin-top: 10px; font-weight: bold;">
                Correo o contraseña incorrectos.
            </p>
        <?php endif; ?>

        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'success'): ?>
            <p style="color: #2ecc71; text-align: center; margin-top: 10px; font-weight: bold;">
                Registro exitoso. ¡Inicia sesión!
            </p>
        <?php endif; ?>
        
        <div style="text-align: center; margin-top: 15px;">
            <p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
        </div>
    </div>
</div>

</body>
</html>