<?php

require_once '../app/core/Database.php';

$uri = $_SERVER['REQUEST_URI'];

if (str_starts_with($uri, '/noticias/crear')) {
  require_once '../app/controllers/NoticiasController.php';
  $controlador = new NoticiasController();
  $controlador->crear();
} else {
  require_once '../app/controllers/NoticiasController.php';
  $controlador = new NoticiasController();
  $controlador->index();
}
