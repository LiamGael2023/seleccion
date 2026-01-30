<?php
$pageTitle = 'Áreas';
$pageHeader = 'Gestión de Áreas';
$pageActions = '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevaArea">
    <i class="ti ti-plus""></i> Nueva Área
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
                        <th>Estado</th>
                        <th class="w-1">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($areas)): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No hay áreas registradas</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($areas as $area): ?>
                    <tr>
                        <td><?= $area['id'] ?></td>
                        <td><?= htmlspecialchars($area['nombre']) ?></td>
                        <td><?= htmlspecialchars($area['descripcion'] ?? '') ?></td>
                        <td>
                            <span class="badge <?= $area['activo'] ? 'bg-success' : 'bg-secondary' ?>">
                                <?= $area['activo'] ? 'Activa' : 'Inactiva' ?>
                            </span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary"
                                onclick="editarArea(<?= $area['id'] ?>, '<?= htmlspecialchars($area['nombre'], ENT_QUOTES) ?>', '<?= htmlspecialchars($area['descripcion'] ?? '', ENT_QUOTES) ?>')">
                                <i class="ti ti-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger"
                                onclick="eliminarArea(<?= $area['id'] ?>)">
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

<!-- Modal Nueva Área -->
<div class="modal modal-blur fade" id="modalNuevaArea" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Área</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= APP_URL ?>/admin/areas/store" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3"></textarea>
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

<!-- Modal Editar Área -->
<div class="modal modal-blur fade" id="modalEditarArea" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Área</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditarArea" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Nombre</label>
                        <input type="text" name="nombre" id="edit_nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" id="edit_descripcion" class="form-control" rows="3"></textarea>
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
$customScripts = <<<'HTML'
<script>
function editarArea(id, nombre, descripcion) {
    document.getElementById('edit_nombre').value = nombre;
    document.getElementById('edit_descripcion').value = descripcion;
    document.getElementById('formEditarArea').action = '<?= APP_URL ?>/admin/areas/' + id + '/update';

    var modal = new bootstrap.Modal(document.getElementById('modalEditarArea'));
    modal.show();
}

function eliminarArea(id) {
    if (confirm('¿Estás seguro de eliminar esta área?')) {
        window.location.href = '<?= APP_URL ?>/admin/areas/' + id + '/delete';
    }
}
</script>
HTML;
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/admin.php';
?>
