<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Noticias</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f6f8;
    }

    /* NAVBAR */
    .navbar {
      background-color: #007bff;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .navbar .brand {
      font-size: 22px;
      color: white;
      font-weight: bold;
      text-decoration: none;
    }

    .navbar nav a {
      color: white;
      text-decoration: none;
      margin-left: 20px;
      font-size: 16px;
      font-weight: 500;
      transition: opacity 0.2s;
    }

    .navbar nav a:hover {
      opacity: 0.85;
    }

    /* NOTICIAS */
    .container {
      max-width: 900px;
      margin: 30px auto;
      padding: 0 20px;
    }

    .noticia-item {
      background-color: #fff;
      border: 1px solid #e0e0e0;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 30px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.06);
      transition: transform 0.2s ease;
    }

    .noticia-item:hover {
      transform: translateY(-3px);
    }

    .noticia-titulo {
      color: #2c3e50;
      font-size: 24px;
      margin-bottom: 15px;
      border-bottom: 1px solid #eaeaea;
      padding-bottom: 8px;
    }

    .noticia-imagen-container {
      text-align: center;
      margin-bottom: 15px;
    }

    .noticia-imagen {
      max-width: 100%;
      height: auto;
      border-radius: 6px;
      border: 1px solid #ddd;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .noticia-contenido {
      color: #555;
      font-size: 16px;
      line-height: 1.6;
      margin-bottom: 20px;
    }

    .noticia-leer-mas {
      display: inline-block;
      background-color: #007bff;
      color: white;
      padding: 10px 18px;
      border-radius: 5px;
      text-decoration: none;
      font-size: 14px;
      transition: background-color 0.25s ease;
    }

    .noticia-leer-mas:hover {
      background-color: #0056b3;
    }

    .noticia-separador {
      border: 0;
      height: 1px;
      background-image: linear-gradient(to right, rgba(0,0,0,0), rgba(0,0,0,0.1), rgba(0,0,0,0));
      margin: 40px 0;
    }

    .no-noticias {
      text-align: center;
      color: #888;
      font-style: italic;
      padding: 25px;
      border: 1px dashed #bbb;
      background-color: #f9f9f9;
      border-radius: 6px;
      font-size: 16px;
    }
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <header class="navbar">
    <a href="http://localhost/SistNoticias" class="brand">📰 Noticias</a>
    <nav>
      <a href="http://localhost/SistNoticias/noticias">Ver Noticias</a>
      <a href="http://localhost/SistNoticias/noticias/crear">Crear Noticia</a>
    </nav>
  </header>

  <!-- CONTENIDO -->
  <div class="container">
    <?php
    if (!empty($data['noticias']) && is_array($data['noticias'])) {
      foreach ($data['noticias'] as $noticia) {
        $titulo = htmlspecialchars($noticia['titulo'] ?? 'Título no disponible');
        $imagenMiniatura = htmlspecialchars($noticia['imagen_miniatura'] ?? 'default.jpg');
        $contenido = htmlspecialchars($noticia['contenido'] ?? 'Contenido no disponible');
        $contenidoCorto = (strlen($contenido) > 200) ? substr($contenido, 0, 200) . '...' : $contenido;

        echo "<div class='noticia-item'>";
        echo "  <h2 class='noticia-titulo'>{$titulo}</h2>";
        echo "  <div class='noticia-imagen-container'>";
        echo "    <img src='http://localhost/SistNoticias/public/uploads/miniaturas/{$imagenMiniatura}' alt='Imagen de la noticia: {$titulo}' class='noticia-imagen'>";
        echo "  </div>";
        echo "  <p class='noticia-contenido'>{$contenidoCorto}</p>";

        if (isset($noticia['id'])) {
          echo "  <a href='http://localhost/SistNoticias/noticias/ver/{$noticia['id']}' class='noticia-leer-mas'>Leer más</a>";
        }

        echo "</div>";
        echo "<hr class='noticia-separador'>";
      }
    } else {
      echo "<p class='no-noticias'>No hay noticias disponibles en este momento.</p>";
    }
    ?>
  </div>

</body>
</html>
