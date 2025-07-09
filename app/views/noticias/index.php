<?php

foreach ($data['noticias'] as $noticia) {
  echo "<h2>{$noticia['titulo']}</h2>";
  echo "<img src='/uploads/{$noticia['imagen_miniatura']}' width='150'>";
  echo "<p>{$noticia['contenido']}</p><hr>";
}
