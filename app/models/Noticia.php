<?php

class Noticia
{
  private $db;
  public function __construct()
  {
    $this->db = Database::getInstance();
  }

  public function guardar($titulo, $contenido, $imagen_original, $imagen_miniatura, $id_usuario)
  {
    $stmt = $this->db->prepare("INSERT INTO noticias (titulo, contenido, imagen_original, imagen_miniatura, id_usuario) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$titulo, $contenido, $imagen_original, $imagen_miniatura, $id_usuario]);
  }

  public function obtenerTodas()
  {
    $stmt = $this->db->query("SELECT * FROM noticias");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function obtenerUno($id)
  {
    $stmt = $this->db->query("SELECT * FROM noticias WHERE id = '$id'");
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
