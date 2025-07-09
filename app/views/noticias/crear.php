<form method="POST" enctype="multipart/form-data" class="news-form">
  <h2>Crear Nueva Noticia</h2>

  <div class="form-group">
    <label for="titulo">Título de la Noticia:</label>
    <input type="text" id="titulo" name="titulo" placeholder="Ej: Nuevo descubrimiento científico" required>
  </div>

  <div class="form-group">
    <label for="contenido">Contenido de la Noticia:</label>
    <textarea id="contenido" name="contenido" placeholder="Escribe aquí el cuerpo de tu noticia..." rows="8" required></textarea>
  </div>

  <div class="form-group">
    <label for="imagen">Seleccionar Imagen:</label>
    <input type="file" id="imagen" name="imagen" accept="image/*">
    <small>Formatos aceptados: JPG, PNG, GIF. Tamaño máximo: 2MB.</small>
  </div>

  <div class="form-actions">
    <button type="submit" class="btn-submit">Guardar Noticia</button>
    <button type="reset" class="btn-reset">Limpiar Campos</button>
  </div>
</form>

<style>
  /* Estilos básicos para mejorar la apariencia */
  .news-form {
    max-width: 600px;
    margin: 30px auto;
    padding: 25px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
  }

  .news-form h2 {
    text-align: center;
    color: #333;
    margin-bottom: 25px;
    font-size: 24px;
    border-bottom: 1px solid #eee;
    padding-bottom: 15px;
  }

  .form-group {
    margin-bottom: 20px;
  }

  .form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #555;
  }

  .form-group input[type="text"],
  .form-group textarea {
    width: calc(100% - 20px);
    /* Ajusta para padding */
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    box-sizing: border-box;
    /* Incluye padding y borde en el ancho */
  }

  .form-group textarea {
    resize: vertical;
    /* Permite redimensionar verticalmente */
  }

  .form-group input[type="file"] {
    padding: 5px 0;
    /* Espacio para el input de tipo file */
  }

  .form-group small {
    display: block;
    margin-top: 5px;
    color: #777;
    font-size: 13px;
  }

  .form-actions {
    text-align: right;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
  }

  .btn-submit,
  .btn-reset {
    padding: 12px 25px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    transition: background-color 0.3s ease;
  }

  .btn-submit {
    background-color: #007bff;
    color: white;
    margin-left: 10px;
  }

  .btn-submit:hover {
    background-color: #0056b3;
  }

  .btn-reset {
    background-color: #6c757d;
    color: white;
  }

  .btn-reset:hover {
    background-color: #5a6268;
  }

  /* Media Queries para adaptabilidad básica */
  @media (max-width: 768px) {
    .news-form {
      margin: 20px 15px;
      padding: 20px;
    }
  }
</style>