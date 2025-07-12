<?php
session_start();
include 'includes/conexion.php';
include 'includes/funciones.php';

$tituloPagina = "Sistema de Administración de Noticias";
$totalUsuarios = totalUsuarios($pdo);  // Obtener total de usuarios
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $tituloPagina ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://via.placeholder.com/1920x600');
            background-size: cover;
            color: white;
            padding: 120px 0;
            margin-bottom: 40px;
        }
        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: #0d6efd;
        }
    </style>
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-newspaper"></i> Sistema de Noticias
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (estaLogueado()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">
                                <i class="bi bi-speedometer2"></i> Panel
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">
                                <i class="bi bi-box-arrow-right"></i> Salir
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">
                                <i class="bi bi-box-arrow-in-right"></i> Ingresar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="usuarios/crear.php">
                                <i class="bi bi-person-plus"></i> Registrarse
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero-section text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">Sistema Administrador de Noticias</h1>
        <p class="lead">Plataforma académica para la gestión de contenido periodístico</p>
        <?php if (!estaLogueado()): ?>
            <div class="mt-4">
                <a href="login.php" class="btn btn-primary btn-lg me-2">
                    <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
                </a>
                <?php if ($totalUsuarios == 0): ?>
                    <a href="usuarios/crear.php" class="btn btn-success btn-lg">
                        <i class="bi bi-person-plus"></i> Crear primer usuario
                    </a>
                <?php else: ?>
                    <a href="usuarios/crear.php" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-person-plus"></i> Registrarse
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

    <div class="container">
        <div class="row mb-5">
            <div class="col-md-4 text-center">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="feature-icon">
                            <i class="bi bi-card-image"></i>
                        </div>
                        <h3>Gestión de Imágenes</h3>
                        <p>Sube y redimensiona imágenes automáticamente para tus noticias.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 text-center">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="feature-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <h3>Administración de Usuarios</h3>
                        <p>Controla los accesos y permisos con nuestro sistema CRUD de usuarios.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 text-center">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="feature-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <h3>Seguridad Avanzada</h3>
                        <p>Protección de contraseñas y manejo seguro de sesiones.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="bi bi-info-circle"></i> Acerca del Proyecto</h4>
                    </div>
                    <div class="card-body">
                        <p>Este sistema fue desarrollado como parte del curso de Desarrollo de Software VII en la Universidad Tecnológica de Panamá.</p>
                        <h5>Características principales:</h5>
                        <ul>
                            <li>Módulo completo de usuarios con CRUD</li>
                            <li>Sistema de autenticación seguro</li>
                            <li>Gestión de noticias con imágenes</li>
                            <li>Redimensionamiento automático de imágenes</li>
                            <li>Interfaz responsive con Bootstrap 5</li>
                        </ul>
                        <p class="mb-0"><strong>Grupo:</strong> 1GS131 | <strong>Instructora:</strong> Ing. Irina Fong</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Universidad Tecnológica de Panamá</h5>
                    <p>Facultad de Ingeniería en Sistemas Computacionales<br>Campus Victor Levis Sasso</p>
                </div>
                <div class="col-md-6 text-end">
                    <p class="mb-0">&copy; <?= date('Y') ?> Sistema de Noticias<br>Desarrollo de Software VII</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>