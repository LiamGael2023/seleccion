<?php
$pageTitle = $convocatoria['titulo'];
ob_start();
?>

<div class="page-header d-print-none mt-4">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <a href="<?= APP_URL ?>/">← Volver a convocatorias</a>
                </div>
                <h2 class="page-title"><?= htmlspecialchars($convocatoria['titulo']) ?></h2>
                <?php if (!empty($convocatoria['descripcion'])): ?>
                <div class="text-muted mt-2"><?= nl2br(htmlspecialchars($convocatoria['descripcion'])) ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-8">
        <h3 class="mb-3">Perfiles Disponibles (<?= count($perfiles) ?>)</h3>

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
        <?php foreach ($perfiles as $perfil): ?>
        <div class="card mb-3">
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <strong>Área:</strong> <?= htmlspecialchars($perfil['area_nombre']) ?>
                        </div>

                        <?php if ($perfil['experiencia_requerida'] > 0): ?>
                        <div class="mb-3">
                            <strong>Experiencia Requerida:</strong> <?= $perfil['experiencia_requerida'] ?> años
                        </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <strong>Descripción:</strong><br>
                            <?= nl2br(htmlspecialchars($perfil['descripcion'])) ?>
                        </div>

                        <div class="mb-3">
                            <strong>Requisitos:</strong><br>
                            <?= nl2br(htmlspecialchars($perfil['requisitos'])) ?>
                        </div>

                        <?php if (!empty($perfil['responsabilidades'])): ?>
                        <div class="mb-3">
                            <strong>Responsabilidades:</strong><br>
                            <?= nl2br(htmlspecialchars($perfil['responsabilidades'])) ?>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($perfil['carreras'])): ?>
                        <div class="mb-3">
                            <strong>Carreras Aceptadas:</strong><br>
                            <div class="d-flex flex-wrap gap-2 mt-1">
                                <?php foreach ($perfil['carreras'] as $carrera): ?>
                                <span class="badge bg-blue-lt"><?= htmlspecialchars($carrera['nombre']) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="<?= APP_URL ?>/perfil/<?= $perfil['id'] ?>/aplicar" class="btn btn-primary">
                    <i class="ti ti-send icon"></i> Postularme a este Perfil
                </a>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Información General</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="text-muted small">Tipo de Contrato</div>
                    <div><strong><?= ucfirst(str_replace('_', ' ', $convocatoria['tipo_contrato'])) ?></strong></div>
                </div>

                <?php if ($convocatoria['salario_min'] && $convocatoria['salario_max']): ?>
                <div class="mb-3">
                    <div class="text-muted small">Rango Salarial</div>
                    <div><strong>$<?= number_format($convocatoria['salario_min'], 2) ?> - $<?= number_format($convocatoria['salario_max'], 2) ?></strong></div>
                </div>
                <?php endif; ?>

                <div class="mb-3">
                    <div class="text-muted small">Fecha de Inicio</div>
                    <div><strong><?= date('d/m/Y', strtotime($convocatoria['fecha_inicio'])) ?></strong></div>
                </div>

                <div class="mb-3">
                    <div class="text-muted small">Fecha de Cierre</div>
                    <div><strong><?= date('d/m/Y', strtotime($convocatoria['fecha_cierre'])) ?></strong></div>
                </div>

                <div class="mb-3">
                    <div class="text-muted small">Publicado</div>
                    <div><strong><?= date('d/m/Y', strtotime($convocatoria['created_at'])) ?></strong></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/public.php';
?>
