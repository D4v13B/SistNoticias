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
      move_uploaded_file($imagen['tmp_name'], "../public/uploads/" . $nombre_archivo);

      // Miniatura
      $miniatura = "mini_" . $nombre_archivo;
      copy("../public/uploads/" . $nombre_archivo, "../public/uploads/" . $miniatura);

      $modelo = $this->model('Noticia');
      $modelo->guardar($titulo, $contenido, $nombre_archivo, $miniatura, $usuario_id);
      header('Location: /noticias');
    }
    $this->view('noticias/crear');
  }
}
