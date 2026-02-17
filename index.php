<?php
session_start();

if (isset($_SESSION['id_user'])) {
    header("Location: views/index.php");
} else {
    header("Location: views/login.php");
}

exit();
?>