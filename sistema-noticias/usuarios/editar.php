<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit;
}

include '../includes/conexion.php';

// Obtener usuario actual
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$_GET['id']]);
$usuario = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    
    // Actualizar datos
    $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?");
    $stmt->execute([$nombre, $email, $_GET['id']]);
    
    // Si se envió nueva contraseña
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
        $stmt->execute([$password, $_GET['id']]);
    }
    
    header('Location: index.php');
    exit;
}
?>

<h1>Editar Usuario</h1>
<form method="POST">
    <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
    <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
    <input type="password" name="password" placeholder="Nueva contraseña (dejar en blanco para no cambiar)">
    <button type="submit">Actualizar</button>
</form>