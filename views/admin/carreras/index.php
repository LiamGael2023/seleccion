<?php
$pageTitle = 'Carreras';
$pageHeader = 'Gestión de Carreras';
$pageActions = '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevaCarrera">
    <i class="ti ti-plus icon"></i> Nueva Carrera
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
                        <th>Nivel</th>
                        <th>Estado</th>
                        <th class="w-1">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($carreras)): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No hay carreras registradas</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($carreras as $carrera): ?>
                    <tr>
                        <td><?= $carrera['id'] ?></td>
                        <td><?= htmlspecialchars($carrera['nombre']) ?></td>
                        <td><?= ucfirst($carrera['nivel']) ?></td>
                        <td>
                            <span class="badge <?= $carrera['activo'] ? 'bg-success' : 'bg-secondary' ?>">
                                <?= $carrera['activo'] ? 'Activa' : 'Inactiva' ?>
                            </span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary"
                                onclick="editarCarrera(<?= $carrera['id'] ?>, '<?= htmlspecialchars($carrera['nombre'], ENT_QUOTES) ?>', '<?= $carrera['nivel'] ?>')">
                                <i class="ti ti-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger"
                                onclick="eliminarCarrera(<?= $carrera['id'] ?>)">
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

<!-- Modal Nueva Carrera -->
<div class="modal modal-blur fade" id="modalNuevaCarrera" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Carrera</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= APP_URL ?>/admin/carreras/store" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Nivel</label>
                        <select name="nivel" class="form-select" required>
                            <option value="tecnico">Técnico</option>
                            <option value="licenciatura">Licenciatura</option>
                            <option value="ingenieria">Ingeniería</option>
                            <option value="maestria">Maestría</option>
                            <option value="doctorado">Doctorado</option>
                        </select>
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

<!-- Modal Editar Carrera -->
<div class="modal modal-blur fade" id="modalEditarCarrera" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Carrera</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditarCarrera" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Nombre</label>
                        <input type="text" name="nombre" id="edit_nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Nivel</label>
                        <select name="nivel" id="edit_nivel" class="form-select" required>
                            <option value="tecnico">Técnico</option>
                            <option value="licenciatura">Licenciatura</option>
                            <option value="ingenieria">Ingeniería</option>
                            <option value="maestria">Maestría</option>
                            <option value="doctorado">Doctorado</option>
                        </select>
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
function editarCarrera(id, nombre, nivel) {
    document.getElementById('edit_nombre').value = nombre;
    document.getElementById('edit_nivel').value = nivel;
    document.getElementById('formEditarCarrera').action = '$appUrl/admin/carreras/' + id + '/update';

    var modal = new bootstrap.Modal(document.getElementById('modalEditarCarrera'));
    modal.show();
}

function eliminarCarrera(id) {
    if (confirm('¿Estás seguro de eliminar esta carrera?')) {
        window.location.href = '$appUrl/admin/carreras/' + id + '/delete';
    }
}
</script>
HTML;
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/admin.php';
?>
