<?php
$pageTitle = $convocatoria['titulo'];
ob_start();
?>

<!-- Header mejorado -->
<div class="page-header d-print-none mt-4 fade-in">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle mb-2">
                    <a href="<?= APP_URL ?>/" class="text-muted">
                        <i class="ti ti-arrow-left icon me-1"></i>
                        Volver a convocatorias
                    </a>
                </div>
                <h2 class="page-title mb-2">
                    <i class="ti ti-briefcase icon me-2"></i>
                    <?= htmlspecialchars($convocatoria['titulo']) ?>
                </h2>
                <?php if (!empty($convocatoria['descripcion'])): ?>
                <div class="text-muted mt-2 fs-5"><?= nl2br(htmlspecialchars($convocatoria['descripcion'])) ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h3 class="mb-0">
                <i class="ti ti-users icon me-2"></i>
                Perfiles Disponibles
            </h3>
            <span class="badge bg-blue-lt" style="font-size: 1rem; padding: 0.5rem 1rem;">
                <?= count($perfiles) ?> <?= count($perfiles) == 1 ? 'Perfil' : 'Perfiles' ?>
            </span>
        </div>

        <?php if (empty($perfiles)): ?>
        <div class="card">
            <div class="card-body text-center py-5">
                <div class="empty">
                    <div class="empty-icon">
                        <i class="ti ti-briefcase icon" style="font-size: 3rem;"></i>
                    </div>
                    <p class="empty-title">No hay perfiles disponibles</p>
                    <p class="empty-subtitle text-muted">
                        Esta convocatoria aún no tiene perfiles publicados.
                    </p>
                </div>
            </div>
        </div>
        <?php else: ?>
        <?php $delay = 0; ?>
        <?php foreach ($perfiles as $perfil): ?>
        <div class="card perfil-card mb-4 fade-in-delay-<?= min($delay, 3) ?>">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="card-title mb-0">
                            <i class="ti ti-target icon me-2"></i>
                            <?= htmlspecialchars($perfil['titulo']) ?>
                        </h3>
                    </div>
                    <div class="col-auto">
                        <span class="badge bg-blue" style="font-size: 0.9rem; padding: 0.5rem 0.75rem;">
                            <i class="ti ti-users icon me-1"></i>
                            <?= $perfil['vacantes'] ?> <?= $perfil['vacantes'] == 1 ? 'vacante' : 'vacantes' ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-12">
                        <!-- Información básica -->
                        <div class="d-flex align-items-center mb-3">
                            <i class="ti ti-building icon me-2 text-muted"></i>
                            <span><strong>Área:</strong> <?= htmlspecialchars($perfil['area_nombre']) ?></span>
                            <?php if ($perfil['experiencia_requerida'] > 0): ?>
                            <span class="mx-2">•</span>
                            <i class="ti ti-clock icon me-2 text-muted"></i>
                            <span><strong>Experiencia:</strong> <?= $perfil['experiencia_requerida'] ?> años</span>
                            <?php endif; ?>
                        </div>

                        <!-- Descripción -->
                        <div class="mb-3">
                            <h5 class="mb-2">
                                <i class="ti ti-file-text icon me-1"></i>
                                Descripción
                            </h5>
                            <div class="text-muted">
                                <?= nl2br(htmlspecialchars($perfil['descripcion'])) ?>
                            </div>
                        </div>

                        <!-- Requisitos -->
                        <div class="mb-3">
                            <h5 class="mb-2">
                                <i class="ti ti-list-check icon me-1"></i>
                                Requisitos
                            </h5>
                            <div class="text-muted">
                                <?= nl2br(htmlspecialchars($perfil['requisitos'])) ?>
                            </div>
                        </div>

                        <!-- Responsabilidades -->
                        <?php if (!empty($perfil['responsabilidades'])): ?>
                        <div class="mb-3">
                            <h5 class="mb-2">
                                <i class="ti ti-clipboard-list icon me-1"></i>
                                Responsabilidades
                            </h5>
                            <div class="text-muted">
                                <?= nl2br(htmlspecialchars($perfil['responsabilidades'])) ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Carreras -->
                        <?php if (!empty($perfil['carreras'])): ?>
                        <div class="mb-0">
                            <h5 class="mb-2">
                                <i class="ti ti-school icon me-1"></i>
                                Carreras Aceptadas
                            </h5>
                            <div class="d-flex flex-wrap gap-2">
                                <?php foreach ($perfil['carreras'] as $carrera): ?>
                                <span class="badge bg-cyan-lt" style="font-size: 0.85rem; padding: 0.5rem 0.75rem;">
                                    <?= htmlspecialchars($carrera['nombre']) ?>
                                </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <a href="<?= APP_URL ?>/perfil/<?= $perfil['id'] ?>/aplicar" class="btn btn-primary btn-lg">
                    <i class="ti ti-send icon me-1"></i>
                    Postularme a este Perfil
                </a>
            </div>
        </div>
        <?php $delay = ($delay + 1) % 4; ?>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Sidebar: Información de la Convocatoria -->
    <div class="col-lg-4">
        <div class="card fade-in-delay-1 sticky-top" style="top: 20px;">
            <div class="card-header" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                <h3 class="card-title text-white">
                    <i class="ti ti-info-circle icon me-2"></i>
                    Información General
                </h3>
            </div>
            <div class="card-body">
                <!-- Tipo de Contrato -->
                <div class="mb-3 pb-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-file-text icon me-2 text-muted"></i>
                        <div>
                            <small class="text-muted d-block">Tipo de Contrato</small>
                            <strong><?= ucfirst(str_replace('_', ' ', $convocatoria['tipo_contrato'])) ?></strong>
                        </div>
                    </div>
                </div>

                <!-- Salario -->
                <?php if ($convocatoria['salario_min'] && $convocatoria['salario_max']): ?>
                <div class="mb-3 pb-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-currency-dollar icon me-2 text-muted"></i>
                        <div>
                            <small class="text-muted d-block">Rango Salarial</small>
                            <strong>$<?= number_format($convocatoria['salario_min'], 2) ?> - $<?= number_format($convocatoria['salario_max'], 2) ?></strong>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Fecha de Inicio -->
                <div class="mb-3 pb-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-calendar-event icon me-2 text-muted"></i>
                        <div>
                            <small class="text-muted d-block">Fecha de Inicio</small>
                            <strong><?= date('d/m/Y', strtotime($convocatoria['fecha_inicio'])) ?></strong>
                        </div>
                    </div>
                </div>

                <!-- Fecha de Cierre -->
                <div class="mb-3 pb-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-calendar-x icon me-2 text-muted"></i>
                        <div>
                            <small class="text-muted d-block">Fecha de Cierre</small>
                            <strong><?= date('d/m/Y', strtotime($convocatoria['fecha_cierre'])) ?></strong>
                        </div>
                    </div>
                </div>

                <!-- Publicado -->
                <div class="mb-0">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-clock icon me-2 text-muted"></i>
                        <div>
                            <small class="text-muted d-block">Publicado</small>
                            <strong><?= date('d/m/Y', strtotime($convocatoria['created_at'])) ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/public.php';
?>
