<?php
// Función para verificar sesión activa
function estaLogueado() {
    return isset($_SESSION['usuario_id']);
}

// Función para redirigir usuarios no autenticados
function verificarAutenticacion() {
    if (!estaLogueado()) {
        header('Location: login.php');
        exit;
    }
}

// Función para sanitizar entradas
function limpiarEntrada($dato) {
    return htmlspecialchars(strip_tags(trim($dato)));
}

// Función para mostrar alertas
function mostrarAlerta($tipo, $mensaje) {
    return '<div class="alert alert-'.$tipo.' alert-dismissible fade show" role="alert">
        '.$mensaje.'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}

// Función para formatear fecha
function formatoFecha($fecha) {
    return date('d/m/Y H:i', strtotime($fecha));
}

function totalUsuarios($pdo) {
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios");
    return $stmt->fetch()['total'];
}
?>