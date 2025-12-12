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
            </div>
            <div class="col-auto ms-auto">
                <a href="<?= APP_URL ?>/convocatoria/<?= $convocatoria['id'] ?>/aplicar" class="btn btn-primary">
                    <i class="ti ti-send icon"></i> Postularme
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h3>Descripción del Puesto</h3>
                <p><?= nl2br(htmlspecialchars($convocatoria['descripcion'])) ?></p>

                <h3 class="mt-4">Requisitos</h3>
                <p><?= nl2br(htmlspecialchars($convocatoria['requisitos'])) ?></p>

                <?php if (!empty($convocatoria['responsabilidades'])): ?>
                <h3 class="mt-4">Responsabilidades</h3>
                <p><?= nl2br(htmlspecialchars($convocatoria['responsabilidades'])) ?></p>
                <?php endif; ?>

                <?php if (!empty($carreras)): ?>
                <h3 class="mt-4">Carreras Aceptadas</h3>
                <div class="d-flex flex-wrap gap-2">
                    <?php foreach ($carreras as $carrera): ?>
                    <span class="badge bg-blue-lt"><?= htmlspecialchars($carrera['nombre']) ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Información</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="text-muted small">Área</div>
                    <div><strong><?= htmlspecialchars($convocatoria['area_nombre']) ?></strong></div>
                </div>

                <div class="mb-3">
                    <div class="text-muted small">Tipo de Contrato</div>
                    <div><strong><?= ucfirst(str_replace('_', ' ', $convocatoria['tipo_contrato'])) ?></strong></div>
                </div>

                <div class="mb-3">
                    <div class="text-muted small">Experiencia Requerida</div>
                    <div><strong><?= $convocatoria['experiencia_requerida'] ?> años</strong></div>
                </div>

                <?php if ($convocatoria['salario_min'] && $convocatoria['salario_max']): ?>
                <div class="mb-3">
                    <div class="text-muted small">Rango Salarial</div>
                    <div><strong>$<?= number_format($convocatoria['salario_min'], 2) ?> - $<?= number_format($convocatoria['salario_max'], 2) ?></strong></div>
                </div>
                <?php endif; ?>

                <div class="mb-3">
                    <div class="text-muted small">Vacantes</div>
                    <div><strong><?= $convocatoria['vacantes'] ?></strong></div>
                </div>

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
            <div class="card-footer">
                <a href="<?= APP_URL ?>/convocatoria/<?= $convocatoria['id'] ?>/aplicar" class="btn btn-primary w-100">
                    <i class="ti ti-send icon"></i> Postularme Ahora
                </a>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/public.php';
?>
