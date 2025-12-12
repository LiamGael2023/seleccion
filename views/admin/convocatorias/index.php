<?php
$pageTitle = 'Convocatorias';
$pageHeader = 'Convocatorias';
$pageActions = '<a href="' . APP_URL . '/admin/convocatorias/create" class="btn btn-primary">
    <i class="ti ti-plus icon"></i> Nueva Convocatoria
</a>';
ob_start();
?>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Área</th>
                        <th>Tipo</th>
                        <th>Vacantes</th>
                        <th>Fecha Cierre</th>
                        <th>Estado</th>
                        <th class="w-1">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($convocatorias)): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            No hay convocatorias registradas
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($convocatorias as $conv): ?>
                    <tr>
                        <td><?= $conv['id'] ?></td>
                        <td><?= htmlspecialchars($conv['titulo']) ?></td>
                        <td class="text-muted"><?= htmlspecialchars($conv['area_nombre']) ?></td>
                        <td><?= ucfirst(str_replace('_', ' ', $conv['tipo_contrato'])) ?></td>
                        <td><?= $conv['vacantes'] ?></td>
                        <td><?= date('d/m/Y', strtotime($conv['fecha_cierre'])) ?></td>
                        <td>
                            <?php
                            $badges = [
                                'borrador' => 'bg-secondary',
                                'publicada' => 'bg-success',
                                'cerrada' => 'bg-dark',
                                'cancelada' => 'bg-danger'
                            ];
                            $badge = $badges[$conv['estado']] ?? 'bg-secondary';
                            ?>
                            <span class="badge <?= $badge ?>"><?= ucfirst($conv['estado']) ?></span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="<?= APP_URL ?>/admin/convocatorias/<?= $conv['id'] ?>/postulaciones" class="btn btn-sm btn-info" title="Ver postulaciones">
                                    <i class="ti ti-users"></i>
                                </a>
                                <a href="<?= APP_URL ?>/admin/convocatorias/<?= $conv['id'] ?>/edit" class="btn btn-sm btn-primary" title="Editar">
                                    <i class="ti ti-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmarEliminar(<?= $conv['id'] ?>)" title="Eliminar">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$customScripts = <<<'HTML'
<script>
function confirmarEliminar(id) {
    if (confirm('¿Estás seguro de eliminar esta convocatoria?')) {
        window.location.href = '<?= APP_URL ?>/admin/convocatorias/' + id + '/delete';
    }
}
</script>
HTML;
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/admin.php';
?>
