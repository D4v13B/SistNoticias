<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Nueva Noticia</title>
    <style>
        body {
            background-color: #eef2f5;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 20px;
        }

        .news-form {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .news-form h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #555;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group textarea,
        .form-group select,
        .form-group input[type="file"] {
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .form-group small {
            color: #666;
            font-size: 12px;
        }

        .form-actions {
            text-align: right;
            margin-top: 25px;
        }

        .btn {
            padding: 12px 25px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-left: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: bold;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .preview {
            max-width: 300px;
            margin: 20px auto;
            text-align: center;
        }

        .preview img {
            max-width: 100%;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #007bff;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="news-form">
        <a href="http://localhost/SistNoticias/noticias" class="back-link">← Volver a Noticias</a>

        <h2>Crear Nueva Noticia</h2>

        <?php if (isset($mensaje)): ?>
            <div class="alert alert-<?php echo $tipo; ?>">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($rutaVistaPrevia)): ?>
            <div class="preview">
                <p>Vista previa de la imagen:</p>
                <img src="/<?php echo htmlspecialchars($rutaVistaPrevia); ?>" alt="Vista previa">
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data"  action="http://localhost/SistNoticias/noticias/crear">
            <div class="form-group">
                <label for="titulo">Título de la Noticia:</label>
                <input type="text" id="titulo" name="titulo"
                    value="<?php echo htmlspecialchars($_POST['titulo'] ?? ''); ?>"
                    placeholder="Ej: Nuevo descubrimiento científico" required>
            </div>

            <div class="form-group">
                <label for="contenido">Contenido de la Noticia:</label>
                <textarea id="contenido" name="contenido"
                    placeholder="Escribe aquí el cuerpo de tu noticia..." required><?php echo htmlspecialchars($_POST['contenido'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label for="imagen">Seleccionar Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*">
                <small>Formatos aceptados: JPG, PNG, GIF. Tamaño máximo: 2MB.</small>
            </div>

            <div class="form-group">
                <label for="ancho">Ancho deseado (px):</label>
                <input type="number" id="ancho" name="ancho" min="1"
                    value="<?php echo htmlspecialchars($_POST['ancho'] ?? ''); ?>"
                    placeholder="Ej: 600">
            </div>

            <div class="form-group">
                <label for="alto">Alto deseado (px):</label>
                <input type="number" id="alto" name="alto" min="1"
                    value="<?php echo htmlspecialchars($_POST['alto'] ?? ''); ?>"
                    placeholder="Ej: 400">
            </div>

            <div class="form-group">
                <label for="modo">Modo de redimensionado:</label>
                <select id="modo" name="modo">
                    <option value="auto" <?php echo ($_POST['modo'] ?? '') === 'auto' ? 'selected' : ''; ?>>Auto</option>
                    <option value="exact" <?php echo ($_POST['modo'] ?? '') === 'exact' ? 'selected' : ''; ?>>Exacto</option>
                    <option value="crop" <?php echo ($_POST['modo'] ?? '') === 'crop' ? 'selected' : ''; ?>>Recortar</option>
                    <option value="portrait" <?php echo ($_POST['modo'] ?? '') === 'portrait' ? 'selected' : ''; ?>>Retrato</option>
                    <option value="landscape" <?php echo ($_POST['modo'] ?? '') === 'landscape' ? 'selected' : ''; ?>>Paisaje</option>
                </select>
                <small>Elige cómo deseas que se ajuste la imagen.</small>
            </div>

            <div class="form-actions">
                <button type="reset" class="btn btn-secondary">Limpiar</button>
                <button type="submit" class="btn btn-primary">Guardar Noticia</button>
            </div>
        </form>
    </div>

</body>

</html>