<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Login</title>
</head>
<body>
<?php include 'layout/header.php'; ?>
<main>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form method="POST" action="../controller/AuthController.php?action=login" class="login-register">
                <input type="text" name="email" placeholder="Correo electrónico" required>
                <input type="password" name="pass" placeholder="Contraseña" required>
                <button type="submit" class="btn-principal">Ingresar</button>
        </form>
        
        <?php if(isset($_GET['error'])): ?>
            <p style="color: red; text-align: center; margin-top: 10px;">Correo o contraseña incorrectos.</p>
        <?php endif; ?>

        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'success'): ?>
            <p style="color: green; text-align: center; margin-top: 10px;">Registro exitoso. ¡Inicia sesión!</p>
        <?php endif; ?>
    </div>
</main>
</body>
</html>