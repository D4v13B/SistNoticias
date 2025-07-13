<?php
require_once '../app/models/Usuario.php';

class AuthController extends Controller
{
    private $usuarioModel;

    public function __construct(PDO $conexion)
    {
        $this->usuarioModel = new Usuario($conexion);
    }

    // Mostrar formulario login
    public function mostrarLogin()
    {
        session_start();
        if (isset($_SESSION['usuario'])) {
            header('Location: /SistNoticias/noticias');
            exit;
        }
        $this->view("auth/login");
    }

    // Procesar login POST
    public function login()
    {
        session_start();
        if (isset($_SESSION['usuario'])) {
            // Ya logueado, redirigir a noticias
            header('Location: /SistNoticias/noticias');
            exit;
        }

        $correo = $_POST['correo'] ?? '';
        $contrasena = $_POST['contrasena'] ?? '';

        $usuario = $this->usuarioModel->obtenerPorCorreo($correo);

        if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
            if ($usuario['activo'] != 1) {
                $error = "Usuario inactivo. Contacta al administrador.";
                $this->view("auth/login");
                // return;
            }

            // Guardar datos en sesión
            $_SESSION['usuario'] = [
                'id' => $usuario['id'],
                'nombre' => $usuario['nombre'],
                'correo' => $usuario['correo']
            ];
            header('Location: /SistNoticias/noticias');
            exit;
        } else {
            $error = "Correo o contraseña incorrectos.";
            $this->view("auth/login");
        }
    }

    // Mostrar formulario registro
    public function mostrarRegistro()
    {
        session_start();
        if (isset($_SESSION['usuario'])) {
            header('Location: /SistNoticias/noticias');
            exit;
        }
        $this->view("auth/registro");
    }

    // Procesar registro POST
    public function registrar()
    {
        session_start();
        if (isset($_SESSION['usuario'])) {
            header('Location: /SistNoticias/noticias');
            exit;
        }

        $nombre = trim($_POST['nombre'] ?? '');
        $correo = trim($_POST['correo'] ?? '');
        $contrasena = $_POST['contrasena'] ?? '';

        if (empty($nombre) || empty($correo) || empty($contrasena)) {
            $error = "Por favor completa todos los campos.";
            $this->view("auth/registro");
            return;
        }

        // Validar email
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $error = "Correo inválido.";
            $this->view("auth/registro");
            return;
        }

        // Intentar registrar
        $exito = $this->usuarioModel->registrar($nombre, $correo, $contrasena);

        if ($exito) {
            header('Location: /SistNoticias/login');
            exit;
        } else {
            $error = "Error al registrar. Es posible que el correo ya esté registrado.";
            $this->view("auth/registro");
        }
    }

    // Logout
    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /SistNoticias/login');
        exit;
    }
}
