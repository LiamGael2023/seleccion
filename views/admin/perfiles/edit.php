<?php
$pageTitle = 'Editar Perfil';
$pageHeader = 'Editar Perfil: ' . $perfil['titulo'];
ob_start();
?>

<div class="card">
    <div class="card-body">
        <form action="<?= APP_URL ?>/admin/perfiles/<?= $perfil['id'] ?>/update" method="post">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label required">Título del Perfil/Puesto</label>
                        <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($perfil['titulo']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="4" required><?= htmlspecialchars($perfil['descripcion']) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Requisitos</label>
                        <textarea name="requisitos" class="form-control" rows="4" required><?= htmlspecialchars($perfil['requisitos']) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Responsabilidades</label>
                        <textarea name="responsabilidades" class="form-control" rows="4"><?= htmlspecialchars($perfil['responsabilidades'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label required">Área</label>
                        <select name="area_id" class="form-select" required>
                            <option value="">Seleccionar...</option>
                            <?php foreach ($areas as $area): ?>
                            <option value="<?= $area['id'] ?>" <?= $area['id'] == $perfil['area_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($area['nombre']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Carreras Aceptadas</label>
                        <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column" style="max-height: 400px; overflow-y: auto;">
                            <?php
                            $categoriaActual = null;
                            foreach ($carreras as $carrera):
                                if ($categoriaActual !== ($carrera['categoria_nombre'] ?? 'Sin Categoría')):
                                    if ($categoriaActual !== null): ?>
                                    </div>
                                    <?php endif;
                                    $categoriaActual = $carrera['categoria_nombre'] ?? 'Sin Categoría'; ?>
                                    <div class="mb-2">
                                        <strong class="text-muted" style="font-size: 0.85rem;"><?= htmlspecialchars($categoriaActual) ?></strong>
                                    </div>
                                    <div class="mb-3">
                                <?php endif; ?>
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
                            <?php if ($categoriaActual !== null): ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Experiencia Requerida (años)</label>
                        <input type="number" name="experiencia_requerida" class="form-control" min="0" value="<?= $perfil['experiencia_requerida'] ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Número de Vacantes</label>
                        <input type="number" name="vacantes" class="form-control" min="1" value="<?= $perfil['vacantes'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Orden de Visualización</label>
                        <input type="number" name="orden" class="form-control" min="0" value="<?= $perfil['orden'] ?>">
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <a href="<?= APP_URL ?>/admin/convocatorias/<?= $convocatoria['id'] ?>/perfiles" class="btn btn-link">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy icon"></i> Actualizar Perfil
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/admin.php';
?>
