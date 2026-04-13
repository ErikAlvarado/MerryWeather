<?php
session_start();
// Seguridad: solo admin (idRole 2)
if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != 2) {
    header("Location: ../login.php"); exit;
}

require_once "../../controller/AdminController.php";
$adminCtrl = new AdminController();

if (isset($_POST['delete_user'])) {
    $adminCtrl->deleteUser($_POST['idUser']);
    header("Location: admin_users.php?msg=user_deleted");
}

$users = $adminCtrl->listAllUsers();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <title>Admin - Usuarios</title>
    <style>
        .admin-table { width: 90%; border-collapse: collapse; margin-top: 20px; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .admin-table th, .admin-table td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        .admin-table th { background-color: var(--color-principal); color: white; }
        .btn-small { padding: 8px 15px; width: auto; font-size: 12px; margin: 2px; }
    </style>
</head>
<body>
    <?php include '../layout/header.php'; ?>
    <main class="content">
        <h2>Panel de Gestión de Usuarios</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $u): ?>
                <tr>
                    <td><?php echo $u['idUser']; ?></td>
                    <td><?php echo htmlspecialchars($u['name']); ?></td>
                    <td><?php echo htmlspecialchars($u['email']); ?></td>
                    <td><?php echo ($u['idRole'] == 2) ? 'Admin' : 'Cliente'; ?></td>
                    <td>
                        <form method="POST" style="display:inline;" onsubmit="return confirm('¿Borrar usuario?');">
                            <input type="hidden" name="idUser" value="<?php echo $u['idUser']; ?>">
                            <button type="submit" name="delete_user" class="btn btn-small btn-delete">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>