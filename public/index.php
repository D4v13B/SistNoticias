<?php

require_once '../app/core/Database.php';
// require_once '../app/core/Auth.php';

// Quita la parte del path base para obtener solo la ruta interna
// $uri = str_replace('/SistNoticias/public', '', $_SERVER['REQUEST_URI']);
$uri = str_replace('/SistNoticias', '', $_SERVER['REQUEST_URI']);
// $uri = str_replace('/public', '', $_SERVER['REQUEST_URI']);

$uri = strtok($uri, '?'); // Elimina parámetros GET

require_once '../app/controllers/NoticiasController.php';
require_once '../app/controllers/AuthController.php';
$controladorNoticias = new NoticiasController();
$controladorAuth = new AuthController(Database::getInstance());




if ($uri === '/noticias/crear') {
    $controladorNoticias->crear();
} elseif ($uri === '/noticias' || $uri === '/noticias/') {
    $controladorNoticias->index();
} elseif (preg_match('#^/noticias/ver/(\d+)$#', $uri, $matches)) {
    $id = (int) $matches[1];
    $controladorNoticias->ver($id);
} elseif ($uri === '/login' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $controladorAuth->mostrarLogin();
} elseif ($uri === '/login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controladorAuth->login();
} elseif ($uri === '/registro' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $controladorAuth->mostrarRegistro();
} elseif ($uri === '/registro' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controladorAuth->registrar();
} elseif ($uri === '/logout') {
    $controladorAuth->logout();
} else {
    http_response_code(404);
    echo "Ruta no encontrada";
}
