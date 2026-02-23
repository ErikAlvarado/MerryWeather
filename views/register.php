    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../style.css">
        <title>Login</title>
    </head>
    <body>
    <?php
        include 'layout/header.php';
    ?>
    <main>
        <div class="login-container">
        <h2>Registrar</h2>

        <form method="POST" action="../controller/AuthController.php?action=register" class="login-register">
                <input type="text" name="name" placeholder="Nombre..." required>
                <input type="text" name="email" placeholder="Correo..." required>
                <input type="password" name="passwordHash" placeholder="Contraseña..." required>

                <select name="idGender" required>
                    <option value="">Selecciona...</option>
                    <option value="1">Hombre</option>
                    <option value="2">Mujer</option>
                    <option value="3">Otro...</option>
                </select>

                <input type="hidden" name="idRole" value="2">

                <button type="submit" class="btn-principal">Ingresar</button>

                <p>Ya tienes una cuenta? <a href="login.php">Inicio de sesion</a></p>
        </form>
    </div>
    </main>
    </body>


