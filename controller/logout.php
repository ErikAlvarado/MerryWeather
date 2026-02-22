<?php
session_start();

/* Vaciar variables de sesión */
$_SESSION = [];

/* Destruir la sesión */
session_destroy();

/* Redirigir a home o login */
header("Location: ../views/home.php");
exit;