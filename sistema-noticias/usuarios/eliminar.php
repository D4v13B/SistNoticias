<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit;
}

include '../includes/conexion.php';

$nuevoEstado = $_GET['estado'];
$id = $_GET['id'];

$stmt = $pdo->prepare("UPDATE usuarios SET activo = ? WHERE id = ?");
$stmt->execute([$nuevoEstado, $id]);

header('Location: index.php');
exit;
?>