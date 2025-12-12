<?php
$pageTitle = 'Dashboard';
$pageHeader = 'Dashboard';
ob_start();
?>

<div class="row row-deck row-cards">
    <div class="col-sm-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Convocatorias Totales</div>
                </div>
                <div class="h1 mb-3"><?= $totalConvocatorias ?></div>
                <div class="d-flex mb-2">
                    <div>Total de convocatorias creadas</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Candidatos</div>
                </div>
                <div class="h1 mb-3"><?= $totalCandidatos ?></div>
                <div class="d-flex mb-2">
                    <div>Total de candidatos registrados</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Postulaciones</div>
                </div>
                <div class="h1 mb-3"><?= $totalPostulaciones ?></div>
                <div class="d-flex mb-2">
                    <div>Total de postulaciones recibidas</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Convocatorias Recientes</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Área</th>
                                <th>Vacantes</th>
                                <th>Fecha Cierre</th>
                                <th>Estado</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($convocatorias)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">No hay convocatorias</td>
                            </tr>
                            <?php else: ?>
                            <?php foreach (array_slice($convocatorias, 0, 10) as $conv): ?>
                            <tr>
                                <td><?= htmlspecialchars($conv['titulo']) ?></td>
                                <td class="text-muted"><?= htmlspecialchars($conv['areas_nombres'] ?? 'Sin áreas asignadas') ?></td>
                                <td><?= $conv['total_vacantes'] ?? 0 ?></td>
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
                                    <a href="<?= APP_URL ?>/admin/convocatorias/<?= $conv['id'] ?>/edit" class="btn btn-sm btn-primary">Ver</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/admin.php';
?>
