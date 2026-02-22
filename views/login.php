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
        <h2>Iniciar Sesión</h2>
        <form method="POST" action="../controller/LoginController.php" class="login-register">
                <input type="text" name="email" placeholder="email" required>
                <input type="password" name="pass" placeholder="password" required>
                <button type="submit">Ingresar</button>
        </form>
    </div>
</main>
</body>
</html>

            
             <?php if(isset($_GET['error'])): ?>
                <p style="color: red;">Invalid email or password.</p>
            <?php endif; ?>

           <!-- <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit" class="btn-primary">Login</button>
            <p>Don't have an account? <a href="register.php">Register here</a></p> -->
