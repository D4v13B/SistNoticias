<?php
$noticia = $data["noticia"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($noticia['titulo']); ?></title>
  <style>
    body {
      background: #f4f6f8;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 800px;
      margin: 40px auto;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      overflow: hidden;
    }

    .header {
      background: #007bff;
      color: white;
      padding: 20px 30px;
      font-size: 24px;
      font-weight: bold;
    }

    .content {
      padding: 30px;
    }

    .content img {
      max-width: 100%;
      border-radius: 8px;
      margin-bottom: 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .content .fecha {
      color: #888;
      font-size: 14px;
      margin-bottom: 15px;
    }

    .content .texto {
      font-size: 18px;
      line-height: 1.6;
      color: #333;
    }

    .footer {
      padding: 20px 30px;
      background: #f1f1f1;
      text-align: right;
      font-size: 14px;
      color: #555;
    }

    .back-link {
      display: inline-block;
      margin-top: 20px;
      color: #007bff;
      text-decoration: none;
    }

    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="header">
      <?php echo htmlspecialchars($noticia['titulo']); ?>
    </div>

    <div class="content">
      <div class="fecha">
        Publicado el <?php echo date("d/m/Y H:i", strtotime($noticia['fecha_publicacion'])); ?>
      </div>

      <img src="http://localhost/SistNoticias/public/uploads/originales/<?php echo htmlspecialchars($noticia['imagen_original']); ?>" alt="Imagen de la noticia">

      <div class="texto">
        <?php echo nl2br(htmlspecialchars($noticia['contenido'])); ?>
      </div>

      <a href="http://localhost/SistNoticias/noticias" class="back-link">← Volver a Noticias</a>
    </div>

    <div class="footer">
      ID del usuario que publicó: <?php echo $noticia['id_usuario']; ?>
    </div>
  </div>

</body>
</html>
