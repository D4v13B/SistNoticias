<?php

require_once '../app/core/Database.php';

// Quita la parte del path base para obtener solo la ruta interna
// $uri = str_replace('/SistNoticias/public', '', $_SERVER['REQUEST_URI']);
$uri = str_replace('/SistNoticias', '', $_SERVER['REQUEST_URI']);
// $uri = str_replace('/public', '', $_SERVER['REQUEST_URI']);

$uri = strtok($uri, '?'); // Elimina parámetros GET

require_once '../app/controllers/NoticiasController.php';
$controlador = new NoticiasController();


if ($uri === '/noticias/crear') {
  $controlador->crear();
} else if ($uri === '/noticias' || $uri === '/noticias/') {
  $controlador->index();
} else {
  // Puedes agregar más rutas aquí
  http_response_code(404);
  echo "Ruta no encontrada";
}
