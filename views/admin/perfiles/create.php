<?php
$pageTitle = 'Nuevo Perfil';
$pageHeader = 'Nuevo Perfil para: ' . $convocatoria['titulo'];
ob_start();
?>

<div class="card">
    <div class="card-body">
        <form action="<?= APP_URL ?>/admin/convocatorias/<?= $convocatoria['id'] ?>/perfiles/store" method="post">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label required">Título del Perfil/Puesto</label>
                        <input type="text" name="titulo" class="form-control" placeholder="Ej: Practicante de Ingeniería Civil" required>
                        <small class="form-hint">Nombre específico del puesto dentro de esta convocatoria</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="4" required placeholder="Describe las funciones y objetivos de este perfil"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Requisitos</label>
                        <textarea name="requisitos" class="form-control" rows="4" required placeholder="Lista los requisitos específicos para este perfil"></textarea>
                        <small class="form-hint">Ej: Conocimientos en AutoCAD, dominio de Excel, etc.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Responsabilidades</label>
                        <textarea name="responsabilidades" class="form-control" rows="4" placeholder="Detalla las responsabilidades del puesto (opcional)"></textarea>
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
                        <label class="form-label">Carreras Aceptadas</label>
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
                        <small class="form-hint">Selecciona las carreras afines a este perfil</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Experiencia Requerida (años)</label>
                        <input type="number" name="experiencia_requerida" class="form-control" min="0" value="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label required">Número de Vacantes</label>
                        <input type="number" name="vacantes" class="form-control" min="1" value="1" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Orden de Visualización</label>
                        <input type="number" name="orden" class="form-control" min="0" value="0">
                        <small class="form-hint">Orden en que aparecerá este perfil (0 = primero)</small>
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <a href="<?= APP_URL ?>/admin/convocatorias/<?= $convocatoria['id'] ?>/perfiles" class="btn btn-link">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy""></i> Guardar Perfil
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/admin.php';
?>
