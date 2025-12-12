<?php
$pageTitle = 'Perfiles - ' . $convocatoria['titulo'];
$pageHeader = 'Gestión de Perfiles';
$pageActions = '<a href="' . APP_URL . '/admin/convocatorias/' . $convocatoria['id'] . '/perfiles/create" class="btn btn-primary">
    <i class="ti ti-plus icon"></i> Nuevo Perfil
</a>';
ob_start();
?>

<div class="row mb-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-1"><?= htmlspecialchars($convocatoria['titulo']) ?></h3>
                        <?php if (!empty($convocatoria['descripcion'])): ?>
                        <p class="text-muted mb-0"><?= htmlspecialchars($convocatoria['descripcion']) ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="col-auto">
                        <div class="btn-list">
                            <a href="<?= APP_URL ?>/admin/convocatorias/<?= $convocatoria['id'] ?>/edit" class="btn btn-outline-primary">
                                <i class="ti ti-pencil icon"></i> Editar Convocatoria
                            </a>
                            <a href="<?= APP_URL ?>/admin/convocatorias" class="btn btn-outline-secondary">
                                <i class="ti ti-arrow-left icon"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (empty($perfiles)): ?>
<div class="empty">
    <div class="empty-icon">
        <i class="ti ti-briefcase icon" style="font-size: 3rem;"></i>
    </div>
    <p class="empty-title">No hay perfiles creados</p>
    <p class="empty-subtitle text-muted">
        Los perfiles son los puestos específicos dentro de esta convocatoria.<br>
        Por ejemplo: "Practicante Ing. Civil - Operación y Mantenimiento"
    </p>
    <div class="empty-action">
        <a href="<?= APP_URL ?>/admin/convocatorias/<?= $convocatoria['id'] ?>/perfiles/create" class="btn btn-primary">
            <i class="ti ti-plus icon"></i> Crear Primer Perfil
        </a>
    </div>
</div>
<?php else: ?>
<div class="row row-cards">
    <?php foreach ($perfiles as $perfil): ?>
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="card-title"><?= htmlspecialchars($perfil['titulo']) ?></h3>
                    </div>
                    <div class="col-auto">
                        <span class="badge bg-blue"><?= $perfil['vacantes'] ?> <?= $perfil['vacantes'] == 1 ? 'vacante' : 'vacantes' ?></span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <strong>Área:</strong> <?= htmlspecialchars($perfil['area_nombre']) ?>
                </div>
                <div class="mb-2">
                    <strong>Experiencia:</strong> <?= $perfil['experiencia_requerida'] ?> años
                </div>
                <div class="mb-3">
                    <strong>Descripción:</strong><br>
                    <small class="text-muted"><?= htmlspecialchars(substr($perfil['descripcion'], 0, 100)) ?><?= strlen($perfil['descripcion']) > 100 ? '...' : '' ?></small>
                </div>
                <div class="mb-3">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-users icon me-2 text-muted"></i>
                        <span><?= $perfil['total_postulaciones'] ?? 0 ?> postulaciones</span>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="btn-list">
                    <a href="<?= APP_URL ?>/admin/perfiles/<?= $perfil['id'] ?>/postulaciones" class="btn btn-info btn-sm">
                        <i class="ti ti-users icon"></i> Postulaciones
                    </a>
                    <a href="<?= APP_URL ?>/admin/perfiles/<?= $perfil['id'] ?>/edit" class="btn btn-primary btn-sm">
                        <i class="ti ti-pencil icon"></i> Editar
                    </a>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmarEliminar(<?= $perfil['id'] ?>)">
                        <i class="ti ti-trash icon"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php
$appUrl = APP_URL;
$customScripts = <<<HTML
<script>
function confirmarEliminar(id) {
    if (confirm('¿Estás seguro de eliminar este perfil? Se eliminarán todas sus postulaciones.')) {
        window.location.href = '$appUrl/admin/perfiles/' + id + '/delete';
    }
}
</script>
HTML;
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/admin.php';
?>
