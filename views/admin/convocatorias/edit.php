<?php
$pageTitle = 'Editar Convocatoria';
$pageHeader = 'Editar Convocatoria';
ob_start();
?>

<div class="card">
    <div class="card-body">
        <form action="<?= APP_URL ?>/admin/convocatorias/<?= $convocatoria['id'] ?>/update" method="post">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label required">Título de la Convocatoria</label>
                        <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($convocatoria['titulo']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción General</label>
                        <textarea name="descripcion" class="form-control" rows="4"><?= htmlspecialchars($convocatoria['descripcion'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label required">Tipo de Contrato</label>
                        <select name="tipo_contrato" class="form-select" required>
                            <option value="practicas" <?= $convocatoria['tipo_contrato'] == 'practicas' ? 'selected' : '' ?>>Prácticas</option>
                            <option value="tiempo_completo" <?= $convocatoria['tipo_contrato'] == 'tiempo_completo' ? 'selected' : '' ?>>Tiempo Completo</option>
                            <option value="medio_tiempo" <?= $convocatoria['tipo_contrato'] == 'medio_tiempo' ? 'selected' : '' ?>>Medio Tiempo</option>
                            <option value="temporal" <?= $convocatoria['tipo_contrato'] == 'temporal' ? 'selected' : '' ?>>Temporal</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Salario Mín.</label>
                                <input type="number" name="salario_min" class="form-control" step="0.01" value="<?= $convocatoria['salario_min'] ?>">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Salario Máx.</label>
                                <input type="number" name="salario_max" class="form-control" step="0.01" value="<?= $convocatoria['salario_max'] ?>">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Fecha de Inicio</label>
                        <input type="date" name="fecha_inicio" class="form-control" value="<?= $convocatoria['fecha_inicio'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Fecha de Cierre</label>
                        <input type="date" name="fecha_cierre" class="form-control" value="<?= $convocatoria['fecha_cierre'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Estado</label>
                        <select name="estado" class="form-select" required>
                            <option value="borrador" <?= $convocatoria['estado'] == 'borrador' ? 'selected' : '' ?>>Borrador</option>
                            <option value="publicada" <?= $convocatoria['estado'] == 'publicada' ? 'selected' : '' ?>>Publicada</option>
                            <option value="cerrada" <?= $convocatoria['estado'] == 'cerrada' ? 'selected' : '' ?>>Cerrada</option>
                            <option value="cancelada" <?= $convocatoria['estado'] == 'cancelada' ? 'selected' : '' ?>>Cancelada</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <a href="<?= APP_URL ?>/admin/convocatorias" class="btn btn-link">Cancelar</a>
                <a href="<?= APP_URL ?>/admin/convocatorias/<?= $convocatoria['id'] ?>/perfiles" class="btn btn-info">
                    <i class="ti ti-list"></i> Gestionar Perfiles
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy"></i> Actualizar Convocatoria
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Sección de Anexos PDF -->
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">
            <i class="ti ti-file-text"></i> Anexos de la Convocatoria
        </h3>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            <div class="d-flex">
                <div><i class="ti ti-info-circle alert-icon"></i></div>
                <div>
                    <h4 class="alert-title">¿Qué son los anexos?</h4>
                    <div class="text-muted">Los anexos son formatos en PDF que los postulantes deben descargar, llenar y presentar junto con su postulación. Puedes subir declaraciones juradas, formatos de datos personales, etc.</div>
                </div>
            </div>
        </div>

        <!-- Formulario para subir anexo -->
        <form action="<?= APP_URL ?>/admin/convocatorias/<?= $convocatoria['id'] ?>/anexos/subir" method="post" enctype="multipart/form-data" class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label required">Archivo PDF</label>
                        <input type="file" name="archivo" class="form-control" accept=".pdf" required>
                        <small class="form-hint">Solo archivos PDF. Tamaño máximo: 10MB</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <input type="text" name="descripcion" class="form-control" placeholder="Ej: Declaración Jurada">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label class="form-label">Orden</label>
                        <input type="number" name="orden" class="form-control" value="0" min="0">
                    </div>
                </div>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="obligatorio" class="form-check-input" id="obligatorio" checked>
                <label class="form-check-label" for="obligatorio">
                    Obligatorio (marcar si los postulantes deben descargar este anexo)
                </label>
            </div>
            <button type="submit" class="btn btn-success">
                <i class="ti ti-upload"></i> Subir Anexo
            </button>
        </form>

        <hr>

        <!-- Lista de anexos -->
        <h4 class="mb-3">Anexos Actuales</h4>
        <?php if (empty($anexos)): ?>
            <div class="empty">
                <div class="empty-icon">
                    <i class="ti ti-file-off"></i>
                </div>
                <p class="empty-title">No hay anexos</p>
                <p class="empty-subtitle text-muted">
                    Aún no se han subido anexos para esta convocatoria
                </p>
            </div>
        <?php else: ?>
            <div class="list-group list-group-flush">
                <?php foreach ($anexos as $anexo): ?>
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="avatar" style="background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0OCIgaGVpZ2h0PSI0OCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9ImN1cnJlbnRDb2xvciIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiPjxwYXRoIGQ9Ik0xNCAySDZhMiAyIDAgMCAwLTIgMnYxNmEyIDIgMCAwIDAgMiAyaDEyYTIgMiAwIDAgMCAyLTJWOHoiPjwvcGF0aD48cG9seWxpbmUgcG9pbnRzPSIxNCAyIDE0IDggMjAgOCI+PC9wb2x5bGluZT48L3N2Zz4=)"></span>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center">
                                    <strong><?= htmlspecialchars($anexo['nombre_original']) ?></strong>
                                    <?php if ($anexo['obligatorio']): ?>
                                        <span class="badge bg-red ms-2">Obligatorio</span>
                                    <?php endif; ?>
                                </div>
                                <div class="text-muted mt-1">
                                    <?php if (!empty($anexo['descripcion'])): ?>
                                        <?= htmlspecialchars($anexo['descripcion']) ?> •
                                    <?php endif; ?>
                                    <?= require_once BASE_PATH . '/models/ConvocatoriaAnexo.php'; echo ConvocatoriaAnexo::formatearTamanio($anexo['tamanio']); ?>
                                    • Subido: <?= date('d/m/Y', strtotime($anexo['created_at'])) ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <a href="<?= APP_URL ?>/anexo/<?= $anexo['id'] ?>/descargar" class="btn btn-sm btn-primary" target="_blank">
                                    <i class="ti ti-download"></i> Descargar
                                </a>
                                <a href="<?= APP_URL ?>/admin/convocatorias/<?= $convocatoria['id'] ?>/anexos/<?= $anexo['id'] ?>/eliminar"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('¿Estás seguro de eliminar este anexo?')">
                                    <i class="ti ti-trash"></i> Eliminar
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/admin.php';
?>
