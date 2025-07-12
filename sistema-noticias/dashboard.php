<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

include 'includes/conexion.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Panel de Control</title>
</head>
<body>
    <h1>Bienvenido, <?= htmlspecialchars($_SESSION['usuario_nombre']) ?></h1>
    <a href="logout.php">Cerrar Sesión</a>
    <h2>Menú</h2>
    <ul>
        <li><a href="usuarios/">Administrar Usuarios</a></li>
    </ul>
</body>
</html>