<?php

class Database
{
  private static $instance = null;
  private $conn;

  private function __construct()
  {
    $this->conn = new PDO('mysql:host=127.0.0.1;dbname=sistema_noticias', 'root', 'monchillo24');
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  public static function getInstance()
  {
    if (!self::$instance) {
      self::$instance = new Database();
    }
    return self::$instance->conn;
  }
}
