<?php

// Verificar si $data['noticias'] existe y es un array iterable
if (!empty($data['noticias']) && is_array($data['noticias'])) {
  foreach ($data['noticias'] as $noticia) {
    // Validación básica de los datos para evitar errores si faltan campos
    $titulo = htmlspecialchars($noticia['titulo'] ?? 'Título no disponible');
    $imagenMiniatura = htmlspecialchars($noticia['imagen_miniatura'] ?? 'default.jpg'); // Usar una imagen por defecto
    $contenido = htmlspecialchars($noticia['contenido'] ?? 'Contenido no disponible');

    // Limitar la longitud del contenido para una vista previa
    $contenidoCorto = (strlen($contenido) > 200) ? substr($contenido, 0, 200) . '...' : $contenido;

    echo "<div class='noticia-item'>"; // Contenedor para cada noticia
    echo "  <h2 class='noticia-titulo'>{$titulo}</h2>";

    // Asegurarse de que la ruta de la imagen sea correcta y exista
    // Podrías añadir una lógica para verificar si la imagen existe en el servidor
    // y mostrar una imagen placeholder si no es así.
    echo "  <div class='noticia-imagen-container'>";
    echo "    <img src='/uploads/{$imagenMiniatura}' alt='Imagen de la noticia: {$titulo}' class='noticia-imagen'>";
    echo "  </div>"; // Cierre del contenedor de imagen

    echo "  <p class='noticia-contenido'>{$contenidoCorto}</p>";

    // Enlace para ver la noticia completa (asumiendo que tienes una ruta para esto)
    // Reemplaza 'noticias/ver' con la ruta real de tu controlador/método para ver una noticia individual
    // Asegúrate de que $noticia['id'] exista o el campo que uses como identificador
    if (isset($noticia['id'])) {
      echo "  <a href='/noticias/ver/{$noticia['id']}' class='noticia-leer-mas'>Leer más</a>";
    }

    echo "</div>"; // Cierre del contenedor de la noticia
    echo "<hr class='noticia-separador'>"; // Separador entre noticias
  }
} else {
  echo "<p class='no-noticias'>No hay noticias disponibles en este momento.</p>";
}

?>

<style>
  /* Estilos básicos para las noticias */
  .noticia-item {
    background-color: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 25px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    font-family: Arial, sans-serif;
  }

  .noticia-titulo {
    color: #333;
    font-size: 24px;
    margin-top: 0;
    margin-bottom: 15px;
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
  }

  .noticia-imagen-container {
    text-align: center;
    /* Centra la imagen */
    margin-bottom: 15px;
  }

  .noticia-imagen {
    max-width: 100%;
    /* La imagen no excederá el ancho de su contenedor */
    height: auto;
    /* Mantiene la proporción */
    border-radius: 5px;
    border: 1px solid #ddd;
  }

  .noticia-contenido {
    color: #555;
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 15px;
  }

  .noticia-leer-mas {
    display: inline-block;
    /* Permite aplicar padding y margin */
    background-color: #007bff;
    color: white;
    padding: 8px 15px;
    border-radius: 5px;
    text-decoration: none;
    /* Quita el subrayado del enlace */
    font-size: 14px;
    transition: background-color 0.3s ease;
  }

  .noticia-leer-mas:hover {
    background-color: #0056b3;
  }

  .noticia-separador {
    border: 0;
    height: 1px;
    background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0));
    margin: 30px 0;
  }

  .no-noticias {
    text-align: center;
    color: #888;
    font-style: italic;
    padding: 20px;
    border: 1px dashed #ccc;
    background-color: #f0f0f0;
    border-radius: 5px;
  }
</style><?php

        // Verificar si $data['noticias'] existe y es un array iterable
        if (!empty($data['noticias']) && is_array($data['noticias'])) {
          foreach ($data['noticias'] as $noticia) {
            // Validación básica de los datos para evitar errores si faltan campos
            $titulo = htmlspecialchars($noticia['titulo'] ?? 'Título no disponible');
            $imagenMiniatura = htmlspecialchars($noticia['imagen_miniatura'] ?? 'default.jpg'); // Usar una imagen por defecto
            $contenido = htmlspecialchars($noticia['contenido'] ?? 'Contenido no disponible');

            // Limitar la longitud del contenido para una vista previa
            $contenidoCorto = (strlen($contenido) > 200) ? substr($contenido, 0, 200) . '...' : $contenido;

            echo "<div class='noticia-item'>"; // Contenedor para cada noticia
            echo "  <h2 class='noticia-titulo'>{$titulo}</h2>";

            // Asegurarse de que la ruta de la imagen sea correcta y exista
            // Podrías añadir una lógica para verificar si la imagen existe en el servidor
            // y mostrar una imagen placeholder si no es así.
            echo "  <div class='noticia-imagen-container'>";
            echo "    <img src='/uploads/{$imagenMiniatura}' alt='Imagen de la noticia: {$titulo}' class='noticia-imagen'>";
            echo "  </div>"; // Cierre del contenedor de imagen

            echo "  <p class='noticia-contenido'>{$contenidoCorto}</p>";

            // Enlace para ver la noticia completa (asumiendo que tienes una ruta para esto)
            // Reemplaza 'noticias/ver' con la ruta real de tu controlador/método para ver una noticia individual
            // Asegúrate de que $noticia['id'] exista o el campo que uses como identificador
            if (isset($noticia['id'])) {
              echo "  <a href='/noticias/ver/{$noticia['id']}' class='noticia-leer-mas'>Leer más</a>";
            }

            echo "</div>"; // Cierre del contenedor de la noticia
            echo "<hr class='noticia-separador'>"; // Separador entre noticias
          }
        } else {
          echo "<p class='no-noticias'>No hay noticias disponibles en este momento.</p>";
        }

        ?>

<style>
  /* Estilos básicos para las noticias */
  .noticia-item {
    background-color: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 25px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    font-family: Arial, sans-serif;
  }

  .noticia-titulo {
    color: #333;
    font-size: 24px;
    margin-top: 0;
    margin-bottom: 15px;
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
  }

  .noticia-imagen-container {
    text-align: center;
    /* Centra la imagen */
    margin-bottom: 15px;
  }

  .noticia-imagen {
    max-width: 100%;
    /* La imagen no excederá el ancho de su contenedor */
    height: auto;
    /* Mantiene la proporción */
    border-radius: 5px;
    border: 1px solid #ddd;
  }

  .noticia-contenido {
    color: #555;
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 15px;
  }

  .noticia-leer-mas {
    display: inline-block;
    /* Permite aplicar padding y margin */
    background-color: #007bff;
    color: white;
    padding: 8px 15px;
    border-radius: 5px;
    text-decoration: none;
    /* Quita el subrayado del enlace */
    font-size: 14px;
    transition: background-color 0.3s ease;
  }

  .noticia-leer-mas:hover {
    background-color: #0056b3;
  }

  .noticia-separador {
    border: 0;
    height: 1px;
    background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0));
    margin: 30px 0;
  }

  .no-noticias {
    text-align: center;
    color: #888;
    font-style: italic;
    padding: 20px;
    border: 1px dashed #ccc;
    background-color: #f0f0f0;
    border-radius: 5px;
  }
</style>