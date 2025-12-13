<?php
$pageTitle = 'Niveles de Estudio';
$pageHeader = 'Gestión de Niveles de Estudio';
$pageActions = '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoNivel">
    <i class="ti ti-plus icon"></i> Nuevo Nivel
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
                    <?php if (empty($niveles)): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No hay niveles registrados</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($niveles as $nivel): ?>
                    <tr>
                        <td><?= $nivel['id'] ?></td>
                        <td><strong><?= htmlspecialchars($nivel['nombre']) ?></strong></td>
                        <td class="text-muted"><?= htmlspecialchars(substr($nivel['descripcion'] ?? '', 0, 50)) ?><?= strlen($nivel['descripcion'] ?? '') > 50 ? '...' : '' ?></td>
                        <td><?= $nivel['orden'] ?></td>
                        <td>
                            <span class="badge bg-blue-lt"><?= $nivel['total_carreras'] ?> carreras</span>
                        </td>
                        <td>
                            <span class="badge <?= $nivel['activo'] ? 'bg-success' : 'bg-secondary' ?>">
                                <?= $nivel['activo'] ? 'Activo' : 'Inactivo' ?>
                            </span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary"
                                onclick="editarNivel(<?= htmlspecialchars(json_encode($nivel), ENT_QUOTES) ?>)">
                                <i class="ti ti-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger"
                                onclick="eliminarNivel(<?= $nivel['id'] ?>)">
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

<!-- Modal Nuevo Nivel -->
<div class="modal modal-blur fade" id="modalNuevoNivel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Nivel de Estudio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= APP_URL ?>/admin/niveles-estudio/store" method="post">
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
                        <small class="form-hint">Los niveles se ordenarán de menor a mayor</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-check">
                            <input type="checkbox" name="activo" class="form-check-input" checked>
                            <span class="form-check-label">Activo</span>
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

<!-- Modal Editar Nivel -->
<div class="modal modal-blur fade" id="modalEditarNivel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Nivel de Estudio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditarNivel" method="post">
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
                            <span class="form-check-label">Activo</span>
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
function editarNivel(nivel) {
    document.getElementById('edit_nombre').value = nivel.nombre;
    document.getElementById('edit_descripcion').value = nivel.descripcion || '';
    document.getElementById('edit_orden').value = nivel.orden;
    document.getElementById('edit_activo').checked = nivel.activo == 1;
    document.getElementById('formEditarNivel').action = '$appUrl/admin/niveles-estudio/' + nivel.id + '/update';

    var modal = new bootstrap.Modal(document.getElementById('modalEditarNivel'));
    modal.show();
}

function eliminarNivel(id) {
    if (confirm('¿Estás seguro de eliminar este nivel de estudio? Las carreras asociadas no se eliminarán.')) {
        window.location.href = '$appUrl/admin/niveles-estudio/' + id + '/delete';
    }
}
</script>
HTML;
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/admin.php';
?>
