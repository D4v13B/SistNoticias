<?php
session_start();
include '../includes/conexion.php';
include '../includes/funciones.php';

// Permitir acceso sin autenticación para crear el primer usuario
$permisoRegistro = true;

// Verificar si ya existe al menos un usuario
$totalUsuarios = totalUsuarios($pdo);

// Si ya hay usuarios, requerir autenticación
if ($totalUsuarios > 0) {
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: ../login.php');
        exit;
    }
    $permisoRegistro = false;
}

$error = '';
$exito = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Validar contraseña
    if (strlen($password) < 8) {
        $error = "La contraseña debe tener al menos 8 caracteres";
    } else {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        try {
            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$nombre, $email, $passwordHash]);
            
            // Si es el primer usuario, iniciar sesión automáticamente
            if ($totalUsuarios == 0) {
                $_SESSION['usuario_id'] = $pdo->lastInsertId();
                $_SESSION['usuario_nombre'] = $nombre;
                $exito = "Usuario creado exitosamente. Serás redirigido al panel.";
                header("Refresh: 3; url=../dashboard.php");
            } else {
                $exito = "Usuario creado exitosamente";
                header("Refresh: 2; url=index.php");
            }
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                $error = "El email ya está registrado";
            } else {
                $error = "Error al registrar el usuario: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ($totalUsuarios == 0) ? 'Crear primer usuario' : 'Registrar nuevo usuario' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
        }
        .register-card {
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-radius: 15px;
            overflow: hidden;
            max-width: 500px;
            margin: 0 auto;
        }
        .register-header {
            background: linear-gradient(120deg, #0d6efd, #6610f2);
            color: white;
            padding: 30px 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-card">
            <div class="register-header text-center">
                <h2><i class="bi bi-person-plus"></i> 
                    <?= ($totalUsuarios == 0) ? 'Crear primer usuario' : 'Registrar nuevo usuario' ?>
                </h2>
                <p class="mb-0">Sistema de Administración de Noticias</p>
            </div>
            
            <div class="card-body p-4">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                
                <?php if ($exito): ?>
                    <div class="alert alert-success"><?= $exito ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre completo</label>
                        <input type="text" class="form-control" name="nombre" placeholder="Tu nombre" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="tu@email.com" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" name="password" placeholder="Mínimo 8 caracteres" minlength="8" required>
                    </div>
                    
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-person-plus"></i> 
                            <?= ($totalUsuarios == 0) ? 'Crear primer usuario' : 'Registrarse' ?>
                        </button>
                    </div>
                    
                    <?php if ($totalUsuarios > 0): ?>
                        <div class="text-center">
                            <a href="../login.php" class="text-decoration-none">
                                ¿Ya tienes cuenta? Inicia sesión
                            </a>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>