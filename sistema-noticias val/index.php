<?php
session_start();
require '../includes/conexion.php';
require '../includes/funciones.php';

verificarAutenticacion();

$tituloPagina = "Administrar Noticias";

// Obtener noticias
$stmt = $pdo->prepare("SELECT n.*, u.nombre as autor 
                      FROM noticias n
                      JOIN usuarios u ON n.usuario_id = u.id
                      ORDER BY n.fecha_creacion DESC");
$stmt->execute();
$noticias = $stmt->fetchAll();

include '../includes/header.php';
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-newspaper"></i> Administrar Noticias</h1>
        <a href="crear.php" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Crear Nueva Noticia
        </a>
    </div>

    <?php if (empty($noticias)): ?>
        <div class="alert alert-info">
            No hay noticias publicadas aún.
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Imagen</th>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($noticias as $noticia): ?>
                    <tr>
                        <td>
                            <?php if (!empty($noticia['imagen_miniatura'])): ?>
                                <img src="../<?= htmlspecialchars($noticia['imagen_miniatura']) ?>" 
                                     alt="Miniatura" class="img-thumbnail" style="max-width: 80px;">
                            <?php else: ?>
                                <span class="text-muted">Sin imagen</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($noticia['titulo']) ?></td>
                        <td><?= htmlspecialchars($noticia['autor']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($noticia['fecha_creacion'])) ?></td>
                        <td>
                            <div class="btn-group">
                                <a href="editar.php?id=<?= $noticia['id'] ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <a href="eliminar.php?id=<?= $noticia['id'] ?>" class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('¿Estás seguro de eliminar esta noticia?')">
                                    <i class="bi bi-trash"></i> Eliminar
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>