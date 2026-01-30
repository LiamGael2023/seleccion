<?php
$pageTitle = 'Convocatorias Disponibles';
ob_start();
?>

<!-- Hero Section -->
<div class="hero-section">
    <div class="container-xl">
        <div class="row align-items-center py-4">
            <div class="col-lg-8 col-md-10 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-3">Convocatorias Disponibles</h1>
                <p class="lead mb-0">Encuentra tu próxima oportunidad profesional y da el siguiente paso en tu carrera</p>
            </div>
        </div>
    </div>
</div>

<div class="container-xl">
    <div class="row g-4 mt-2">
        <?php if (empty($convocatorias)): ?>
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="empty">
                        <div class="empty-icon">
                            <i class="fas fa-briefcase fs-1"></i>
                        </div>
                        <p class="empty-title h4 mt-3">No hay convocatorias disponibles</p>
                        <p class="empty-subtitle text-muted">
                            Por el momento no tenemos convocatorias activas. Vuelve pronto.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <?php $delay = 0; ?>
        <?php foreach ($convocatorias as $conv): ?>
        <div class="col-md-6 col-lg-4 fade-in-delay-<?= min($delay, 3) ?>">
            <div class="card convocatoria-card h-100">
                <div class="card-body d-flex flex-column">
                    <div class="mb-3">
                        <h3 class="card-title mb-2"><?= htmlspecialchars($conv['titulo']) ?></h3>
                        <div class="d-flex gap-2 flex-wrap">
                            <span class="badge bg-blue-lt">
                                <i class="fas fa-briefcase me-1"></i>
                                <?= ucfirst(str_replace('_', ' ', $conv['tipo_contrato'])) ?>
                            </span>
                            <span class="badge bg-cyan-lt">
                                <i class="fas fa-users me-1"></i>
                                <?= $conv['total_perfiles'] ?? 0 ?> perfiles
                            </span>
                        </div>
                    </div>

                    <?php if (!empty($conv['descripcion'])): ?>
                    <div class="mb-3 text-muted">
                        <?= nl2br(htmlspecialchars(substr($conv['descripcion'], 0, 150))) ?>
                        <?= strlen($conv['descripcion']) > 150 ? '...' : '' ?>
                    </div>
                    <?php endif; ?>

                    <div class="mt-auto">
                        <div class="d-flex align-items-center text-muted small mb-3">
                            <i class="fas fa-calendar me-2"></i>
                            <span><strong>Inicio:</strong> <?= date('d/m/Y', strtotime($conv['fecha_inicio'])) ?></span>
                            <span class="mx-2">•</span>
                            <span><strong>Cierre:</strong> <?= date('d/m/Y', strtotime($conv['fecha_cierre'])) ?></span>
                        </div>
                        <a href="<?= APP_URL ?>/convocatoria/<?= $conv['id'] ?>" class="btn btn-primary w-100">
                            <i class="fas fa-arrow-right me-1"></i>
                            Ver Perfiles Disponibles
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php $delay = ($delay + 1) % 4; ?>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/public.php';
?>
