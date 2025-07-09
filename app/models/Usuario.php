<?php

class Usuario
{
  private $db;
  public function __construct()
  {
    $this->db = Database::getInstance();
  }

  public function obtenerTodos()
  {
    $stmt = $this->db->query("SELECT * FROM usuarios");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function guardar($nombre, $correo, $contrasena)
  {
    $stmt = $this->db->prepare("INSERT INTO usuarios (nombre, correo, contrasena) VALUES (?, ?, ?)");
    return $stmt->execute([$nombre, $correo, password_hash($contrasena, PASSWORD_DEFAULT)]);
  }
} 
