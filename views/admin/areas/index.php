<?php
$pageTitle = 'Áreas';
$pageHeader = 'Gestión de Áreas';
$pageActions = '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevaArea">
    <i class="ti ti-plus icon"></i> Nueva Área
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
                        <th>Área Padre</th>
                        <th>Estado</th>
                        <th class="w-1">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($areas)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No hay áreas registradas</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($areas as $area): ?>
                    <tr>
                        <td><?= $area['id'] ?></td>
                        <td>
                            <?php if (empty($area['area_padre_id'])): ?>
                                <strong><?= htmlspecialchars($area['nombre']) ?></strong>
                            <?php else: ?>
                                <span class="ms-3">└─ <?= htmlspecialchars($area['nombre']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td><small class="text-muted"><?= htmlspecialchars(substr($area['descripcion'] ?? '', 0, 60)) ?><?= strlen($area['descripcion'] ?? '') > 60 ? '...' : '' ?></small></td>
                        <td>
                            <?php if (!empty($area['area_padre_nombre'])): ?>
                                <span class="badge bg-blue-lt"><?= htmlspecialchars($area['area_padre_nombre']) ?></span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge <?= $area['activo'] ? 'bg-success' : 'bg-secondary' ?>">
                                <?= $area['activo'] ? 'Activa' : 'Inactiva' ?>
                            </span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary"
                                onclick="editarArea(<?= htmlspecialchars(json_encode($area), ENT_QUOTES) ?>)">
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
                    <div class="mb-3">
                        <label class="form-label">Área Padre (Subgerencia)</label>
                        <select name="area_padre_id" class="form-select">
                            <option value="">Ninguna - Es Subgerencia Principal</option>
                            <?php foreach ($areasPadre as $padre): ?>
                            <option value="<?= $padre['id'] ?>"><?= htmlspecialchars($padre['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-hint">Si esta área pertenece a una Subgerencia, selecciónala aquí</small>
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
                    <div class="mb-3">
                        <label class="form-label">Área Padre (Subgerencia)</label>
                        <select name="area_padre_id" id="edit_area_padre_id" class="form-select">
                            <option value="">Ninguna - Es Subgerencia Principal</option>
                            <?php foreach ($areasPadre as $padre): ?>
                            <option value="<?= $padre['id'] ?>"><?= htmlspecialchars($padre['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-hint">Si esta área pertenece a una Subgerencia, selecciónala aquí</small>
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
function editarArea(area) {
    document.getElementById('edit_nombre').value = area.nombre;
    document.getElementById('edit_descripcion').value = area.descripcion || '';
    document.getElementById('edit_area_padre_id').value = area.area_padre_id || '';
    document.getElementById('formEditarArea').action = '$appUrl/admin/areas/' + area.id + '/update';

    var modal = new bootstrap.Modal(document.getElementById('modalEditarArea'));
    modal.show();
}

function eliminarArea(id) {
    if (confirm('¿Estás seguro de eliminar esta área? Si es una Subgerencia, también se eliminarán sus áreas dependientes.')) {
        window.location.href = '$appUrl/admin/areas/' + id + '/delete';
    }
}
</script>
HTML;
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/admin.php';
?>
