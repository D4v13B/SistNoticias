<?php

require_once '../app/core/Controller.php';
require_once '../app/models/resize.php';

class NoticiasController extends Controller
{
    private $carpetaOriginal = 'uploads/originales/';
    private $carpetaMini = 'uploads/miniaturas/';

    public function __construct()
    {
        // Crear directorios si no existen
        if (!is_dir($this->carpetaOriginal)) {
            mkdir($this->carpetaOriginal, 0755, true);
        }
        if (!is_dir($this->carpetaMini)) {
            mkdir($this->carpetaMini, 0755, true);
        }
    }

    public function index()
    {
        $modelo = $this->model('Noticia');
        $noticias = $modelo->obtenerTodas();
        $this->view('noticias/index', ['noticias' => $noticias]);
    }

    public function ver($id){
        $modelo = $this->model('Noticia');

        $noticia = $modelo->obtenerUno($id);
        $this->view("noticias/ver", ['noticia' => $noticia]);
    }

    public function crear()
    {
        $datos = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $titulo = $_POST['titulo'] ?? '';
                $contenido = $_POST['contenido'] ?? '';
                $ancho = isset($_POST['ancho']) ? (int)$_POST['ancho'] : null;
                $alto = isset($_POST['alto']) ? (int)$_POST['alto'] : null;
                $modo = $_POST['modo'] ?? 'auto';
                $usuario_id = $_SESSION['usuario']["id"] ?? 1;

                // Validar datos básicos
                if (empty($titulo) || empty($contenido)) {
                    throw new Exception("El título y contenido son obligatorios");
                }

                $imagen_original = null;
                $imagen_miniatura = null;
                $rutaVistaPrevia = null;

                // Procesar imagen si se subió
                if (!empty($_FILES['imagen']['name'])) {
                    $resultadoImagen = $this->procesarImagen($_FILES['imagen'], $ancho, $alto, $modo);
                    $imagen_original = $resultadoImagen['original'];
                    $imagen_miniatura = $resultadoImagen['miniatura'];
                    $rutaVistaPrevia = $resultadoImagen['ruta_miniatura'];
                }

                // Guardar en base de datos
                $modelo = $this->model('Noticia');
                $resultado = $modelo->guardar($titulo, $contenido, $imagen_original, $imagen_miniatura, $usuario_id);

                if ($resultado) {
                    $datos['mensaje'] = 'Noticia creada exitosamente';
                    $datos['tipo'] = 'success';
                    $datos['rutaVistaPrevia'] = $rutaVistaPrevia;
                } else {
                    throw new Exception("Error al guardar en la base de datos");
                }
            } catch (Exception $e) {
                echo '<div style="
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 5px;
    font-weight: bold;
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;">
' . htmlspecialchars($e->getMessage()) . '</div>';
                $datos['mensaje'] = $e->getMessage();
                $datos['tipo'] = 'error';
            }
        }


        if (isset($datos["mensaje"])) {
    $tipo = isset($datos["tipo"]) ? $datos["tipo"] : "info";
    echo '<div class="alert alert-' . htmlspecialchars($tipo) . '">';
    echo htmlspecialchars($datos["mensaje"]);
    echo '</div>';
}

        $this->view('noticias/crear', $datos);
    }

    public function editar($id)
    {
        $modelo = $this->model('Noticia');
        $noticia = $modelo->obtenerPorId($id);

        if (!$noticia) {
            header('Location: /noticias');
            exit;
        }

        $datos = ['noticia' => $noticia];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $titulo = $_POST['titulo'] ?? '';
                $contenido = $_POST['contenido'] ?? '';
                $ancho = isset($_POST['ancho']) ? (int)$_POST['ancho'] : null;
                $alto = isset($_POST['alto']) ? (int)$_POST['alto'] : null;
                $modo = $_POST['modo'] ?? 'auto';

                if (empty($titulo) || empty($contenido)) {
                    throw new Exception("El título y contenido son obligatorios");
                }

                $imagen_original = $noticia['imagen_original'];
                $imagen_miniatura = $noticia['imagen_miniatura'];

                // Procesar nueva imagen si se subió
                if (!empty($_FILES['imagen']['name'])) {
                    // Eliminar imagen anterior
                    if ($noticia['imagen_original']) {
                        $this->eliminarImagen($noticia['imagen_original']);
                    }

                    $resultadoImagen = $this->procesarImagen($_FILES['imagen'], $ancho, $alto, $modo);
                    $imagen_original = $resultadoImagen['original'];
                    $imagen_miniatura = $resultadoImagen['miniatura'];
                    $datos['rutaVistaPrevia'] = $resultadoImagen['ruta_miniatura'];
                }

                $resultado = $modelo->actualizar($id, $titulo, $contenido, $imagen_original, $imagen_miniatura);

                if ($resultado) {
                    $datos['mensaje'] = 'Noticia actualizada exitosamente';
                    $datos['tipo'] = 'success';
                } else {
                    throw new Exception("Error al actualizar en la base de datos");
                }
            } catch (Exception $e) {
                $datos['mensaje'] = $e->getMessage();
                $datos['tipo'] = 'error';
            }
        }

        $this->view('noticias/editar', $datos);
    }

    public function eliminar($id)
    {
        $modelo = $this->model('Noticia');
        $noticia = $modelo->obtenerPorId($id);

        if ($noticia) {
            // Eliminar archivos de imagen
            if ($noticia['imagen_original']) {
                $this->eliminarImagen($noticia['imagen_original']);
            }

            // Eliminar de base de datos
            $modelo->eliminar($id);
        }

        header('Location: /noticias');
        exit;
    }

    private function procesarImagen($archivo, $ancho = null, $alto = null, $modo = 'auto')
    {
        // Validar archivo
        if (!isset($archivo['tmp_name']) || !$archivo['tmp_name']) {
            throw new Exception("No se recibió ningún archivo");
        }

        if ($archivo['size'] > 2 * 1024 * 1024) { // 2MB
            throw new Exception("La imagen excede los 2MB");
        }

        // Generar nombres únicos
        $nombreSeguro = uniqid() . '_' . basename($archivo['name']);
        $rutaOriginal = $this->carpetaOriginal . $nombreSeguro;
        $rutaMiniatura = $this->carpetaMini . $nombreSeguro;

        // Mover archivo original
        if (!move_uploaded_file($archivo['tmp_name'], $rutaOriginal)) {
            throw new Exception("No se pudo mover la imagen al servidor");
        }

        // Crear miniatura si se especificaron dimensiones
        if ($ancho && $alto) {
            try {
                $imagen = new resize($rutaOriginal);
                $imagen->resizeImage($ancho, $alto, $modo);
                $imagen->saveImage($rutaMiniatura);

                return [
                    'original' => $nombreSeguro,
                    'miniatura' => $nombreSeguro,
                    'ruta_miniatura' => $rutaMiniatura
                ];
            } catch (Exception $e) {
                // Si falla la miniatura, eliminar original y relanzar excepción
                unlink($rutaOriginal);
                throw $e;
            }
        }

        // Si no se especificaron dimensiones, usar la original como miniatura
        copy($rutaOriginal, $rutaMiniatura);

        return [
            'original' => $nombreSeguro,
            'miniatura' => $nombreSeguro,
            'ruta_miniatura' => $rutaMiniatura
        ];
    }

    private function eliminarImagen($nombreArchivo)
    {
        $rutaOriginal = $this->carpetaOriginal . $nombreArchivo;
        $rutaMiniatura = $this->carpetaMini . $nombreArchivo;

        if (file_exists($rutaOriginal)) {
            unlink($rutaOriginal);
        }
        if (file_exists($rutaMiniatura)) {
            unlink($rutaMiniatura);
        }
    }
}
