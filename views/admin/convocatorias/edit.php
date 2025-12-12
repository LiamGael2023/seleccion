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
                        <label class="form-label required">Título del Puesto</label>
                        <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($convocatoria['titulo']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="4" required><?= htmlspecialchars($convocatoria['descripcion']) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Requisitos</label>
                        <textarea name="requisitos" class="form-control" rows="4" required><?= htmlspecialchars($convocatoria['requisitos']) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Responsabilidades</label>
                        <textarea name="responsabilidades" class="form-control" rows="4"><?= htmlspecialchars($convocatoria['responsabilidades'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label required">Área</label>
                        <select name="area_id" class="form-select" required>
                            <option value="">Seleccionar...</option>
                            <?php foreach ($areas as $area): ?>
                            <option value="<?= $area['id'] ?>" <?= $area['id'] == $convocatoria['area_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($area['nombre']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Carreras Requeridas</label>
                        <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column" style="max-height: 300px; overflow-y: auto;">
                            <?php foreach ($carreras as $carrera): ?>
                            <label class="form-selectgroup-item flex-fill">
                                <input type="checkbox" name="carreras[]" value="<?= $carrera['id'] ?>"
                                    class="form-selectgroup-input"
                                    <?= in_array($carrera['id'], $carrerasIds) ? 'checked' : '' ?>>
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
                            <option value="tiempo_completo" <?= $convocatoria['tipo_contrato'] == 'tiempo_completo' ? 'selected' : '' ?>>Tiempo Completo</option>
                            <option value="medio_tiempo" <?= $convocatoria['tipo_contrato'] == 'medio_tiempo' ? 'selected' : '' ?>>Medio Tiempo</option>
                            <option value="temporal" <?= $convocatoria['tipo_contrato'] == 'temporal' ? 'selected' : '' ?>>Temporal</option>
                            <option value="practicas" <?= $convocatoria['tipo_contrato'] == 'practicas' ? 'selected' : '' ?>>Prácticas</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Experiencia Requerida (años)</label>
                        <input type="number" name="experiencia_requerida" class="form-control" min="0" value="<?= $convocatoria['experiencia_requerida'] ?>">
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Salario Mínimo</label>
                                <input type="number" name="salario_min" class="form-control" step="0.01" value="<?= $convocatoria['salario_min'] ?>">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Salario Máximo</label>
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
                        <label class="form-label">Número de Vacantes</label>
                        <input type="number" name="vacantes" class="form-control" min="1" value="<?= $convocatoria['vacantes'] ?>" required>
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
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy icon"></i> Actualizar Convocatoria
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/admin.php';
?>
