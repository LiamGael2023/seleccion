<?php
$pageTitle = $convocatoria['titulo'];
ob_start();
?>

<div class="container-xl">
    <!-- Header -->
    <div class="page-header mt-4 fade-in">
        <div class="mb-3">
            <a href="<?= APP_URL ?>/" class="text-muted text-decoration-none">
                <i class="fas fa-arrow-left me-2"></i>
                Volver a convocatorias
            </a>
        </div>
        <h2 class="page-title mb-3">
            <i class="fas fa-briefcase me-2"></i>
            <?= htmlspecialchars($convocatoria['titulo']) ?>
        </h2>
        <?php if (!empty($convocatoria['descripcion'])): ?>
        <p class="text-muted fs-5"><?= nl2br(htmlspecialchars($convocatoria['descripcion'])) ?></p>
        <?php endif; ?>
    </div>

    <div class="row mt-4 g-4">
        <!-- Columna Principal -->
        <div class="col-lg-8">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h3 class="mb-0">
                    <i class="fas fa-users me-2"></i>
                    Perfiles Disponibles
                </h3>
                <span class="badge bg-blue-lt fs-6 px-3 py-2">
                    <?= count($perfiles) ?> <?= count($perfiles) == 1 ? 'Perfil' : 'Perfiles' ?>
                </span>
            </div>

            <?php if (empty($perfiles)): ?>
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="empty">
                        <i class="fas fa-briefcase fs-1 text-primary mb-3"></i>
                        <h4 class="mt-3">No hay perfiles disponibles</h4>
                        <p class="text-muted">
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
                            <h4 class="card-title mb-0">
                                <i class="fas fa-bullseye me-2"></i>
                                <?= htmlspecialchars($perfil['titulo']) ?>
                            </h4>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-primary fs-6 px-3 py-2">
                                <i class="fas fa-users me-1"></i>
                                <?= $perfil['vacantes'] ?> <?= $perfil['vacantes'] == 1 ? 'vacante' : 'vacantes' ?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Información básica -->
                    <div class="d-flex align-items-center flex-wrap mb-3">
                        <span class="me-4">
                            <i class="fas fa-building me-2 text-muted"></i>
                            <strong>Área:</strong> <?= htmlspecialchars($perfil['area_nombre']) ?>
                        </span>
                        <?php if ($perfil['experiencia_requerida'] > 0): ?>
                        <span>
                            <i class="fas fa-clock me-2 text-muted"></i>
                            <strong>Experiencia:</strong> <?= $perfil['experiencia_requerida'] ?> años
                        </span>
                        <?php endif; ?>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-3">
                        <h5 class="mb-2">
                            <i class="fas fa-file-alt me-2"></i>
                            Descripción
                        </h5>
                        <div class="text-muted">
                            <?= nl2br(htmlspecialchars($perfil['descripcion'])) ?>
                        </div>
                    </div>

                    <!-- Requisitos -->
                    <div class="mb-3">
                        <h5 class="mb-2">
                            <i class="fas fa-tasks me-2"></i>
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
                            <i class="fas fa-clipboard-list me-2"></i>
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
                            <i class="fas fa-graduation-cap me-2"></i>
                            Carreras Aceptadas
                        </h5>
                        <div class="d-flex flex-wrap gap-2">
                            <?php foreach ($perfil['carreras'] as $carrera): ?>
                            <span class="badge bg-cyan-lt fs-6 px-3 py-2">
                                <?= htmlspecialchars($carrera['nombre']) ?>
                            </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <a href="<?= APP_URL ?>/perfil/<?= $perfil['id'] ?>/aplicar" class="btn btn-primary btn-lg">
                        <i class="fas fa-paper-plane me-2"></i>
                        Postularme a este Perfil
                    </a>
                </div>
            </div>
            <?php $delay = ($delay + 1) % 4; ?>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card fade-in-delay-1 sticky-top" style="top: 80px;">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Información General
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Tipo de Contrato -->
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-file-contract fs-5 me-3 text-muted mt-1"></i>
                            <div>
                                <small class="text-muted d-block mb-1">Tipo de Contrato</small>
                                <strong><?= ucfirst(str_replace('_', ' ', $convocatoria['tipo_contrato'])) ?></strong>
                            </div>
                        </div>
                    </div>

                    <!-- Salario -->
                    <?php if ($convocatoria['salario_min'] && $convocatoria['salario_max']): ?>
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-dollar-sign fs-5 me-3 text-muted mt-1"></i>
                            <div>
                                <small class="text-muted d-block mb-1">Rango Salarial</small>
                                <strong>$<?= number_format($convocatoria['salario_min'], 2) ?> - $<?= number_format($convocatoria['salario_max'], 2) ?></strong>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Fecha de Inicio -->
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-calendar-day fs-5 me-3 text-muted mt-1"></i>
                            <div>
                                <small class="text-muted d-block mb-1">Fecha de Inicio</small>
                                <strong><?= date('d/m/Y', strtotime($convocatoria['fecha_inicio'])) ?></strong>
                            </div>
                        </div>
                    </div>

                    <!-- Fecha de Cierre -->
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-calendar-times fs-5 me-3 text-muted mt-1"></i>
                            <div>
                                <small class="text-muted d-block mb-1">Fecha de Cierre</small>
                                <strong><?= date('d/m/Y', strtotime($convocatoria['fecha_cierre'])) ?></strong>
                            </div>
                        </div>
                    </div>

                    <!-- Publicado -->
                    <div class="mb-0">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-clock fs-5 me-3 text-muted mt-1"></i>
                            <div>
                                <small class="text-muted d-block mb-1">Publicado</small>
                                <strong><?= date('d/m/Y', strtotime($convocatoria['created_at'])) ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card de Anexos -->
            <?php if (!empty($anexos)): ?>
            <div class="card mt-4 fade-in-delay-2">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-pdf me-2"></i>
                        Anexos y Formatos
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        <i class="fas fa-info-circle me-1"></i>
                        Descarga los siguientes formatos que debes llenar y presentar con tu postulación:
                    </p>

                    <div class="list-group list-group-flush">
                        <?php foreach ($anexos as $index => $anexo): ?>
                        <div class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="avatar avatar-md" style="background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0OCIgaGVpZ2h0PSI0OCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiNmZjAwMDAiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIj48cGF0aCBkPSJNMTQgMkg2YTIgMiAwIDAgMC0yIDJ2MTZhMiAyIDAgMCAwIDIgMmgxMmEyIDIgMCAwIDAgMi0yVjh6Ij48L3BhdGg+PHBvbHlsaW5lIHBvaW50cz0iMTQgMiAxNCA4IDIwIDgiPjwvcG9seWxpbmU+PHBhdGggZD0iTTkgMTVoNiI+PC9wYXRoPjxwYXRoIGQ9Ik05IDExaDYiPjwvcGF0aD48L3N2Zz4=)"></span>
                                </div>
                                <div class="col">
                                    <div class="d-flex align-items-center">
                                        <strong><?= htmlspecialchars($anexo['nombre_original']) ?></strong>
                                        <?php if ($anexo['obligatorio']): ?>
                                            <span class="badge bg-red-lt ms-2">Obligatorio</span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!empty($anexo['descripcion'])): ?>
                                        <small class="text-muted"><?= htmlspecialchars($anexo['descripcion']) ?></small>
                                    <?php endif; ?>
                                </div>
                                <div class="col-auto">
                                    <a href="<?= APP_URL ?>/anexo/<?= $anexo['id'] ?>/descargar"
                                       class="btn btn-primary btn-sm"
                                       target="_blank">
                                        <i class="fas fa-download me-1"></i>
                                        Descargar
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <?php
                    $obligatorios = array_filter($anexos, function($anexo) { return $anexo['obligatorio']; });
                    if (!empty($obligatorios)):
                    ?>
                    <div class="alert alert-warning mt-3 mb-0">
                        <div class="d-flex">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <div>
                                <strong>Importante:</strong> Los anexos marcados como "Obligatorio" deben ser descargados, llenados correctamente y presentados junto con tu CV.
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/public.php';
?>
