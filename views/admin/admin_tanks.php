<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != 2) {
    header("Location: ../login.php"); exit;
}

require_once "../../controller/AdminController.php";
$adminCtrl = new AdminController();

if (isset($_POST['delete_tank'])) {
    $adminCtrl->deleteTankAdmin($_POST['idTank']);
    header("Location: admin_tanks.php?msg=tank_deleted");
}

$tanks = $adminCtrl->listAllTanks();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <title>Admin - Tanques</title>
    <style>
        .admin-table { width: 90%; border-collapse: collapse; margin-top: 20px; background: white; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .admin-table th, .admin-table td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        .admin-table th { background-color: var(--color-principal); color: white; }
        .btn-small { padding: 8px 15px; width: auto; font-size: 12px; }
    </style>
</head>
<body>
    <?php include '../layout/header.php'; ?>
    <main class="content">
        <h2>Panel de Gestión de Tanques Global</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Propietario</th>
                    <th>Descripción</th>
                    <th>Capacidad</th>
                    <th>Ubicación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($tanks as $t): ?>
                <tr>
                    <td><?php echo $t['idTank']; ?></td>
                    <td><strong><?php echo htmlspecialchars($t['owner']); ?></strong></td>
                    <td><?php echo htmlspecialchars($t['description']); ?></td>
                    <td><?php echo $t['capcity']; ?> L</td>
                    <td><?php echo htmlspecialchars($t['location']); ?></td>
                    <td>
                        <a href="edit_tank_admin.php?idTank=<?php echo $t['idTank']; ?>" class="btn btn-small">Editar</a>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="idTank" value="<?php echo $t['idTank']; ?>">
                            <button type="submit" name="delete_tank" class="btn btn-small btn-delete">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>