<?php
$pageTitle = 'Convocatorias Disponibles';
ob_start();
?>

<div class="page-header d-print-none mt-4">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Convocatorias Disponibles</h2>
                <div class="text-muted mt-1">Encuentra tu próxima oportunidad profesional</div>
            </div>
        </div>
    </div>
</div>

<div class="row row-cards mt-4">
    <?php if (empty($convocatorias)): ?>
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <div class="empty">
                    <div class="empty-icon">
                        <i class="ti ti-briefcase icon" style="font-size: 3rem;"></i>
                    </div>
                    <p class="empty-title">No hay convocatorias disponibles</p>
                    <p class="empty-subtitle text-muted">
                        Por el momento no tenemos convocatorias activas. Vuelve pronto.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <?php foreach ($convocatorias as $conv): ?>
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><?= htmlspecialchars($conv['titulo']) ?></h3>
                <div class="text-muted mb-3">
                    <i class="ti ti-building icon"></i> <?= htmlspecialchars($conv['area_nombre']) ?>
                </div>
                <div class="mb-2">
                    <span class="badge bg-blue-lt">
                        <?= ucfirst(str_replace('_', ' ', $conv['tipo_contrato'])) ?>
                    </span>
                    <?php if ($conv['experiencia_requerida'] > 0): ?>
                    <span class="badge bg-cyan-lt">
                        <?= $conv['experiencia_requerida'] ?> años exp.
                    </span>
                    <?php endif; ?>
                </div>
                <div class="text-muted small mb-3">
                    <i class="ti ti-calendar icon"></i>
                    Cierre: <?= date('d/m/Y', strtotime($conv['fecha_cierre'])) ?>
                </div>
                <div class="mb-3">
                    <?= nl2br(htmlspecialchars(substr($conv['descripcion'], 0, 150))) ?>
                    <?= strlen($conv['descripcion']) > 150 ? '...' : '' ?>
                </div>
                <div class="d-flex">
                    <a href="<?= APP_URL ?>/convocatoria/<?= $conv['id'] ?>" class="btn btn-primary w-100">
                        Ver Detalles
                    </a>
                </div>
            </div>
            <div class="card-footer">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-muted">
                            <?= $conv['vacantes'] ?> <?= $conv['vacantes'] == 1 ? 'vacante' : 'vacantes' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/public.php';
?>
