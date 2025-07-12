<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit;
}

include '../includes/conexion.php';

$stmt = $pdo->query("SELECT * FROM usuarios");
$usuarios = $stmt->fetchAll();
?>

<h1>Administrar Usuarios</h1>
<a href="crear.php">Crear Nuevo Usuario</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($usuarios as $usuario): ?>
    <tr>
        <td><?= $usuario['id'] ?></td>
        <td><?= htmlspecialchars($usuario['nombre']) ?></td>
        <td><?= htmlspecialchars($usuario['email']) ?></td>
        <td><?= $usuario['activo'] ? 'Activo' : 'Inactivo' ?></td>
        <td>
            <a href="editar.php?id=<?= $usuario['id'] ?>">Editar</a>
            <a href="eliminar.php?id=<?= $usuario['id'] ?>&estado=<?= $usuario['activo'] ? 0 : 1 ?>">
                <?= $usuario['activo'] ? 'Desactivar' : 'Activar' ?>
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>