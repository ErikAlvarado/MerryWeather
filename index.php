<?php
session_start();

if (isset($_SESSION['id_user'])) {
    header("Location: views/login.php");
} else {
    header("Location: views/home.php");
}

exit();
?>