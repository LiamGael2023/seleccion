<?php
$pageTitle = 'Nueva Convocatoria';
$pageHeader = 'Nueva Convocatoria';
ob_start();
?>

<div class="alert alert-info">
    <div class="d-flex">
        <div><i class="ti ti-info-circle alert-icon"></i></div>
        <div>
            <h4 class="alert-title">Nueva Convocatoria</h4>
            <div class="text-muted">Una convocatoria es un contenedor que agrupa múltiples perfiles o puestos. Por ejemplo: "Prácticas Profesionales Periodo 1" puede contener varios perfiles como "Practicante Ing. Civil", "Practicante Ing. Agrícola", etc.</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= APP_URL ?>/admin/convocatorias/store" method="post">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label required">Título de la Convocatoria</label>
                        <input type="text" name="titulo" class="form-control" placeholder="Ej: Prácticas Profesionales Periodo 1 - 2025" required>
                        <small class="form-hint">Este es el título general de la convocatoria</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción General</label>
                        <textarea name="descripcion" class="form-control" rows="4" placeholder="Descripción general de la convocatoria (opcional)"></textarea>
                        <small class="form-hint">Puedes agregar una descripción general. Los requisitos específicos se definirán en cada perfil.</small>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label required">Tipo de Contrato</label>
                        <select name="tipo_contrato" class="form-select" required>
                            <option value="practicas" selected>Prácticas</option>
                            <option value="tiempo_completo">Tiempo Completo</option>
                            <option value="medio_tiempo">Medio Tiempo</option>
                            <option value="temporal">Temporal</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Salario Mín.</label>
                                <input type="number" name="salario_min" class="form-control" step="0.01" placeholder="Opcional">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Salario Máx.</label>
                                <input type="number" name="salario_max" class="form-control" step="0.01" placeholder="Opcional">
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
                        <label class="form-label required">Estado</label>
                        <select name="estado" class="form-select" required>
                            <option value="borrador" selected>Borrador</option>
                            <option value="publicada">Publicada</option>
                        </select>
                        <small class="form-hint">Puedes dejarla como borrador y agregar perfiles antes de publicarla</small>
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <a href="<?= APP_URL ?>/admin/convocatorias" class="btn btn-link">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy""></i> Guardar y Agregar Perfiles
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/admin.php';
?>
