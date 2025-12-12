<?php
$pageTitle = 'Nueva Convocatoria';
$pageHeader = 'Nueva Convocatoria';
ob_start();
?>

<div class="card">
    <div class="card-body">
        <form action="<?= APP_URL ?>/admin/convocatorias/store" method="post">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label required">Título del Puesto</label>
                        <input type="text" name="titulo" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="4" required></textarea>
                        <small class="form-hint">Describe el puesto y sus funciones principales</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Requisitos</label>
                        <textarea name="requisitos" class="form-control" rows="4" required></textarea>
                        <small class="form-hint">Lista los requisitos y habilidades necesarias</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Responsabilidades</label>
                        <textarea name="responsabilidades" class="form-control" rows="4"></textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label required">Área</label>
                        <select name="area_id" class="form-select" required>
                            <option value="">Seleccionar...</option>
                            <?php foreach ($areas as $area): ?>
                            <option value="<?= $area['id'] ?>"><?= htmlspecialchars($area['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Carreras Requeridas</label>
                        <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column" style="max-height: 300px; overflow-y: auto;">
                            <?php foreach ($carreras as $carrera): ?>
                            <label class="form-selectgroup-item flex-fill">
                                <input type="checkbox" name="carreras[]" value="<?= $carrera['id'] ?>" class="form-selectgroup-input">
                                <div class="form-selectgroup-label d-flex align-items-center p-2">
                                    <div class="me-2">
                                        <span class="form-selectgroup-check"></span>
                                    </div>
                                    <div>
                                        <small><?= htmlspecialchars($carrera['nombre']) ?></small>
                                    </div>
                                </div>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Tipo de Contrato</label>
                        <select name="tipo_contrato" class="form-select" required>
                            <option value="tiempo_completo">Tiempo Completo</option>
                            <option value="medio_tiempo">Medio Tiempo</option>
                            <option value="temporal">Temporal</option>
                            <option value="practicas">Prácticas</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Experiencia Requerida (años)</label>
                        <input type="number" name="experiencia_requerida" class="form-control" min="0" value="0">
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Salario Mínimo</label>
                                <input type="number" name="salario_min" class="form-control" step="0.01">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Salario Máximo</label>
                                <input type="number" name="salario_max" class="form-control" step="0.01">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Fecha de Inicio</label>
                        <input type="date" name="fecha_inicio" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Fecha de Cierre</label>
                        <input type="date" name="fecha_cierre" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Número de Vacantes</label>
                        <input type="number" name="vacantes" class="form-control" min="1" value="1" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Estado</label>
                        <select name="estado" class="form-select" required>
                            <option value="borrador">Borrador</option>
                            <option value="publicada">Publicada</option>
                        </select>
                        <small class="form-hint">Solo las convocatorias publicadas serán visibles para candidatos</small>
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <a href="<?= APP_URL ?>/admin/convocatorias" class="btn btn-link">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy icon"></i> Guardar Convocatoria
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/admin.php';
?>
