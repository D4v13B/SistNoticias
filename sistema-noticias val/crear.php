<?php
session_start();
require '../includes/conexion.php';
require '../includes/funciones.php';
require '../includes/Validacion.php';

verificarAutenticacion();

$tituloPagina = "Crear Nueva Noticia";
$error = '';
$exito = '';

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar título
    $titulo = Validacion::validarTexto($_POST['titulo']);
    if (is_string($titulo)) {
        $error = $titulo;
    }
    
    // Validar contenido
    $contenido = Validacion::validarTexto($_POST['contenido'], 5000);
    if (is_string($contenido)) {
        $error = $contenido;
    }
    
    // Validar imagen
    $imagenValida = Validacion::esImagenValida($_FILES['imagen']);
    if ($imagenValida !== true) {
        $error = $imagenValida;
    }
    
    // Si no hay errores, procesar
    if (empty($error)) {
        // Crear directorios si no existen
        if (!is_dir('../uploads/originales')) {
            mkdir('../uploads/originales', 0777, true);
        }
        if (!is_dir('../uploads/miniaturas')) {
            mkdir('../uploads/miniaturas', 0777, true);
        }
        
        // Generar nombre único para las imágenes
        $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $nombreOriginal = uniqid('img_') . '.' . $extension;
        $nombreMiniatura = 'thumb_' . $nombreOriginal;
        
        // Mover imagen original
        $rutaOriginal = '../uploads/originales/' . $nombreOriginal;
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaOriginal)) {
            // Aquí se generaría la miniatura (lo hará otro compañero)
            // Por ahora simplemente copiamos la misma imagen
            copy($rutaOriginal, '../uploads/miniaturas/' . $nombreMiniatura);
            
            // Guardar en la base de datos
            try {
                $stmt = $pdo->prepare("INSERT INTO noticias (titulo, contenido, imagen_original, imagen_miniatura, usuario_id) 
                                      VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([
                    $titulo,
                    $contenido,
                    'uploads/originales/' . $nombreOriginal,
                    'uploads/miniaturas/' . $nombreMiniatura,
                    $_SESSION['usuario_id']
                ]);
                
                $exito = "Noticia creada correctamente";
            } catch (PDOException $e) {
                $error = "Error al guardar la noticia: " . $e->getMessage();
            }
        } else {
            $error = "Error al subir la imagen";
        }
    }
}

// Incluir encabezado
include '../includes/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="bi bi-plus-circle"></i> Crear Nueva Noticia</h3>
                </div>
                
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    
                    <?php if ($exito): ?>
                        <div class="alert alert-success"><?= $exito ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" 
                                   value="<?= isset($_POST['titulo']) ? htmlspecialchars($_POST['titulo']) : '' ?>" 
                                   required maxlength="255">
                        </div>
                        
                        <div class="mb-3">
                            <label for="contenido" class="form-label">Contenido</label>
                            <textarea class="form-control" id="contenido" name="contenido" 
                                      rows="6" required><?= isset($_POST['contenido']) ? htmlspecialchars($_POST['contenido']) : '' ?></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label for="imagen" class="form-label">Imagen de la noticia</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" 
                                   accept=".jpg, .jpeg, .png" required>
                            <div class="form-text">Formatos permitidos: JPG, PNG. Tamaño máximo: 2MB</div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle"></i> Publicar Noticia
                            </button>
                            <a href="index.php" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>