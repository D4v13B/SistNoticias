<?php
session_start();

if (!isset($_SESSION['usuario'])) {
  // Usuario no autenticado, redirige a login
  header('Location: /SistNoticias/login');
  exit;
}
