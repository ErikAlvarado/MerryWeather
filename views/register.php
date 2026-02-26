<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Registro</title>
</head>
<body>
<?php include 'layout/header.php'; ?>
<div class="container">
    <div class="login-container">
        <h2>Registrar</h2>
        <form method="POST" action="../controller/AuthController.php?action=register" class="login-register">
                <input class="input" type="text" name="name" placeholder="Nombre completo" required>
                <input class="input" type="email" name="email" placeholder="Correo electrónico" required>
                <input class="input" type="password" name="password" placeholder="Crea una contraseña" required>

                <select class="select" name="idGender" required>
                    <option value="">Selecciona Género...</option>
                    <option value="1">Hombre</option>
                    <option value="2">Mujer</option>
                    <option value="3">Otro...</option>
                </select>

                <input type="hidden" name="idRole" value="2"> 
                <button type="submit" class="btn">Registrarse</button>
                <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a></p>
        </form>
    </div>
</main>
</body>
</html>