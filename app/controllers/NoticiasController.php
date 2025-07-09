<?php

require_once '../app/core/Controller.php';

class NoticiasController extends Controller
{
  public function index()
  {
    $modelo = $this->model('Noticia');
    $noticias = $modelo->obtenerTodas();
    $this->view('noticias/index', ['noticias' => $noticias]);
  }

  public function crear()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $titulo = $_POST['titulo'];
      $contenido = $_POST['contenido'];
      $usuario_id = 1; // Simulación

      $imagen = $_FILES['imagen'];
      $nombre_archivo = time() . '_' . $imagen['name'];

      $uploads_dir = __DIR__ . '/uploads';

      if (!mkdir($uploads_dir, 0755, true)) {
        // Si la creación falla, muestra un mensaje de error y detén la ejecución
        die('Error: No se pudo crear el directorio de subidas. Verifica los permisos.');
      }

      move_uploaded_file($imagen['tmp_name'], $uploads_dir . $nombre_archivo);

      // Miniatura
      $miniatura = "mini_" . $nombre_archivo;
      copy($uploads_dir . $nombre_archivo, $uploads_dir . $miniatura);

      $modelo = $this->model('Noticia');
      $modelo->guardar($titulo, $contenido, $nombre_archivo, $miniatura, $usuario_id);
      header('Location: /noticias');
    }
    $this->view('noticias/crear');
  }
}
