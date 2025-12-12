<?php
$pageTitle = 'Postulaciones - ' . $perfil['titulo'];
$pageHeader = 'Postulaciones';
ob_start();
?>

<div class="row mb-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-muted small">Convocatoria</div>
                        <h3 class="mb-1"><?= htmlspecialchars($convocatoria['titulo']) ?></h3>
                        <div class="text-muted small mt-1">Perfil</div>
                        <h4 class="mb-1"><?= htmlspecialchars($perfil['titulo']) ?></h4>
                        <div class="text-muted">Área: <?= htmlspecialchars($perfil['area_nombre']) ?> | Vacantes: <?= $perfil['vacantes'] ?></div>
                    </div>
                    <div class="col-auto">
                        <a href="<?= APP_URL ?>/admin/convocatorias/<?= $convocatoria['id'] ?>/perfiles" class="btn btn-outline-secondary">
                            <i class="ti ti-arrow-left icon"></i> Volver a Perfiles
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Postulaciones (<?= count($postulaciones) ?>)</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Candidato</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Carrera</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Puntuación</th>
                        <th class="w-1">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($postulaciones)): ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            No hay postulaciones aún para este perfil
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($postulaciones as $post): ?>
                    <tr>
                        <td><?= $post['id'] ?></td>
                        <td><?= htmlspecialchars($post['candidato_nombre']) ?></td>
                        <td><?= htmlspecialchars($post['candidato_email']) ?></td>
                        <td><?= htmlspecialchars($post['candidato_telefono'] ?? '-') ?></td>
                        <td class="text-muted"><?= htmlspecialchars($post['carrera_nombre'] ?? 'N/A') ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($post['fecha_postulacion'])) ?></td>
                        <td>
                            <?php
                            $badges = [
                                'pendiente' => 'bg-secondary',
                                'revision' => 'bg-info',
                                'entrevista' => 'bg-warning',
                                'aceptado' => 'bg-success',
                                'rechazado' => 'bg-danger'
                            ];
                            $badge = $badges[$post['estado']] ?? 'bg-secondary';
                            ?>
                            <span class="badge <?= $badge ?>"><?= ucfirst($post['estado']) ?></span>
                        </td>
                        <td><?= $post['puntuacion'] ?>/100</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary"
                                onclick="editarPostulacion(<?= $post['id'] ?>, '<?= $post['estado'] ?>', <?= $post['puntuacion'] ?>, '<?= htmlspecialchars($post['comentarios'] ?? '', ENT_QUOTES) ?>')">
                                <i class="ti ti-pencil"></i>
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

<!-- Modal para editar postulación -->
<div class="modal modal-blur fade" id="modalEditarPostulacion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Evaluar Postulación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditarPostulacion">
                <div class="modal-body">
                    <input type="hidden" id="postulacion_id" name="id">
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" id="postulacion_estado" class="form-select">
                            <option value="pendiente">Pendiente</option>
                            <option value="revision">En Revisión</option>
                            <option value="entrevista">Entrevista</option>
                            <option value="aceptado">Aceptado</option>
                            <option value="rechazado">Rechazado</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Puntuación (0-100)</label>
                        <input type="number" name="puntuacion" id="postulacion_puntuacion" class="form-control" min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Comentarios</label>
                        <textarea name="comentarios" id="postulacion_comentarios" class="form-control" rows="3"></textarea>
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

<?php
$customScripts = <<<'HTML'
<script>
function editarPostulacion(id, estado, puntuacion, comentarios) {
    document.getElementById('postulacion_id').value = id;
    document.getElementById('postulacion_estado').value = estado;
    document.getElementById('postulacion_puntuacion').value = puntuacion;
    document.getElementById('postulacion_comentarios').value = comentarios;

    var modal = new bootstrap.Modal(document.getElementById('modalEditarPostulacion'));
    modal.show();
}

document.getElementById('formEditarPostulacion').addEventListener('submit', function(e) {
    e.preventDefault();

    var formData = new FormData(this);

    fetch('<?= APP_URL ?>/admin/convocatorias/postulacion/update', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error al actualizar la postulación');
        }
    });
});
</script>
HTML;
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/admin.php';
?>
