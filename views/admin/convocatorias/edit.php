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
                    <i class="ti ti-list""></i> Gestionar Perfiles
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy""></i> Actualizar Convocatoria
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/admin.php';
?>
