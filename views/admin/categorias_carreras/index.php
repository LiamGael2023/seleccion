<?php
$pageTitle = 'Categorías de Carreras';
$pageHeader = 'Gestión de Categorías de Carreras';
$pageActions = '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevaCategoria">
    <i class="ti ti-plus icon"></i> Nueva Categoría
</button>';
ob_start();
?>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Orden</th>
                        <th>Carreras</th>
                        <th>Estado</th>
                        <th class="w-1">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($categorias)): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No hay categorías registradas</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($categorias as $categoria): ?>
                    <tr>
                        <td><?= $categoria['id'] ?></td>
                        <td><strong><?= htmlspecialchars($categoria['nombre']) ?></strong></td>
                        <td class="text-muted"><?= htmlspecialchars(substr($categoria['descripcion'] ?? '', 0, 50)) ?><?= strlen($categoria['descripcion'] ?? '') > 50 ? '...' : '' ?></td>
                        <td><?= $categoria['orden'] ?></td>
                        <td>
                            <span class="badge bg-blue-lt"><?= $categoria['total_carreras'] ?> carreras</span>
                        </td>
                        <td>
                            <span class="badge <?= $categoria['activo'] ? 'bg-success' : 'bg-secondary' ?>">
                                <?= $categoria['activo'] ? 'Activa' : 'Inactiva' ?>
                            </span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary"
                                onclick="editarCategoria(<?= $categoria['id'] ?>, <?= htmlspecialchars(json_encode($categoria), ENT_QUOTES) ?>)">
                                <i class="ti ti-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger"
                                onclick="eliminarCategoria(<?= $categoria['id'] ?>)">
                                <i class="ti ti-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Nueva Categoría -->
<div class="modal modal-blur fade" id="modalNuevaCategoria" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= APP_URL ?>/admin/categorias-carreras/store" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Orden</label>
                        <input type="number" name="orden" class="form-control" value="0" min="0">
                        <small class="form-hint">Las categorías se ordenarán de menor a mayor</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-check">
                            <input type="checkbox" name="activo" class="form-check-input" checked>
                            <span class="form-check-label">Activa</span>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Categoría -->
<div class="modal modal-blur fade" id="modalEditarCategoria" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditarCategoria" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Nombre</label>
                        <input type="text" name="nombre" id="edit_nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" id="edit_descripcion" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Orden</label>
                        <input type="number" name="orden" id="edit_orden" class="form-control" min="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-check">
                            <input type="checkbox" name="activo" id="edit_activo" class="form-check-input">
                            <span class="form-check-label">Activa</span>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$appUrl = APP_URL;
$customScripts = <<<HTML
<script>
function editarCategoria(id, categoria) {
    document.getElementById('edit_nombre').value = categoria.nombre;
    document.getElementById('edit_descripcion').value = categoria.descripcion || '';
    document.getElementById('edit_orden').value = categoria.orden;
    document.getElementById('edit_activo').checked = categoria.activo == 1;
    document.getElementById('formEditarCategoria').action = '$appUrl/admin/categorias-carreras/' + id + '/update';

    var modal = new bootstrap.Modal(document.getElementById('modalEditarCategoria'));
    modal.show();
}

function eliminarCategoria(id) {
    if (confirm('¿Estás seguro de eliminar esta categoría? Las carreras asociadas no se eliminarán.')) {
        window.location.href = '$appUrl/admin/categorias-carreras/' + id + '/delete';
    }
}
</script>
HTML;
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/admin.php';
?>
