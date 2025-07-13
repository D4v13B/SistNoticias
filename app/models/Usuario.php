<?php

class Usuario
{
  private $db;

  public function __construct(PDO $conexion)
  {
    $this->db = $conexion;
  }

  // Registrar nuevo usuario
  public function registrar($nombre, $correo, $contrasena)
  {
    try {
      $hash = password_hash($contrasena, PASSWORD_DEFAULT);
      $stmt = $this->db->prepare("INSERT INTO usuarios (nombre, correo, contrasena) VALUES (?, ?, ?)");
      return $stmt->execute([$nombre, $correo, $hash]);
    } catch (PDOException $e) {
      // Aquí podrías manejar el error, por ejemplo si el correo ya existe
      return false;
    }
  }

  // Obtener usuario activo por correo
  public function obtenerPorCorreo($correo)
  {
    $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE correo = ? AND activo = 1");
    $stmt->execute([$correo]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
