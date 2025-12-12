<?php
$pageTitle = 'Postularse - ' . $perfil['titulo'];
ob_start();
?>

<div class="page-header d-print-none mt-4">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <a href="<?= APP_URL ?>/convocatoria/<?= $convocatoria['id'] ?>">← Volver a la convocatoria</a>
                </div>
                <h2 class="page-title">Postularme</h2>
                <div class="text-muted mt-1"><strong>Convocatoria:</strong> <?= htmlspecialchars($convocatoria['titulo']) ?></div>
                <div class="text-muted"><strong>Perfil:</strong> <?= htmlspecialchars($perfil['titulo']) ?></div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-8">
        <form action="<?= APP_URL ?>/postular" method="post" enctype="multipart/form-data">
            <input type="hidden" name="convocatoria_id" value="<?= $convocatoria['id'] ?>">
            <input type="hidden" name="perfil_id" value="<?= $perfil['id'] ?>">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información Personal</h3>
                </div>
                <div class="card-body">
                    <!-- Datos del usuario registrado (no modificables) -->
                    <div class="alert alert-info mb-3">
                        <div class="d-flex">
                            <div><i class="ti ti-info-circle icon alert-icon"></i></div>
                            <div>
                                <strong>Usuario autenticado:</strong> <?= htmlspecialchars($postulante['nombres'] . ' ' . $postulante['apellido_paterno'] . ' ' . $postulante['apellido_materno']) ?>
                                <br><small>Estos datos fueron verificados al crear tu cuenta y no pueden modificarse.</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Nombres</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($postulante['nombres']) ?>" readonly>
                                <small class="form-hint text-muted">Dato verificado con RENIEC</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Apellido Paterno</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($postulante['apellido_paterno']) ?>" readonly>
                                <small class="form-hint text-muted">Dato verificado con RENIEC</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Apellido Materno</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($postulante['apellido_materno']) ?>" readonly>
                                <small class="form-hint text-muted">Dato verificado con RENIEC</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="<?= htmlspecialchars($postulante['email']) ?>" readonly>
                                <small class="form-hint text-muted">Email de tu cuenta</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Teléfono</label>
                                <input type="tel" name="telefono" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Fecha de Nacimiento</label>
                                <input type="date" name="fecha_nacimiento" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Dirección</label>
                                <input type="text" name="direccion" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Ciudad</label>
                                <input type="text" name="ciudad" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Estado</label>
                                <input type="text" name="estado" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Código Postal</label>
                                <input type="text" name="codigo_postal" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Sexo</label>
                                <select name="sexo" class="form-select" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="masculino">Masculino</option>
                                    <option value="femenino">Femenino</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">¿Presenta discapacidad?</label>
                                <select name="presenta_discapacidad" id="presenta_discapacidad" class="form-select" required>
                                    <option value="no">No</option>
                                    <option value="si">Sí</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="discapacidad_tipo_row" style="display: none;">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Indicar tipo de discapacidad</label>
                                <input type="text" name="tipo_discapacidad" id="tipo_discapacidad" class="form-control"
                                    placeholder="Especifique el tipo de discapacidad">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Formación Académica</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Carrera</label>
                                <select name="carrera_id" class="form-select">
                                    <option value="">Seleccionar...</option>
                                    <?php if (!empty($carreras)): ?>
                                        <optgroup label="Carreras Requeridas para este Perfil">
                                        <?php foreach ($carreras as $carrera): ?>
                                            <option value="<?= $carrera['id'] ?>"><?= htmlspecialchars($carrera['nombre']) ?></option>
                                        <?php endforeach; ?>
                                        </optgroup>
                                    <?php endif; ?>
                                    <?php if (!empty($todasCarreras)): ?>
                                        <optgroup label="Otras Carreras">
                                        <?php foreach ($todasCarreras as $carrera): ?>
                                            <?php if (empty($carreras) || !in_array($carrera['id'], array_column($carreras, 'id'))): ?>
                                            <option value="<?= $carrera['id'] ?>"><?= htmlspecialchars($carrera['nombre']) ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        </optgroup>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nivel de Estudios</label>
                                <select name="nivel_estudios" class="form-select">
                                    <option value="">Seleccionar...</option>
                                    <option value="secundaria">Secundaria</option>
                                    <option value="preparatoria">Preparatoria</option>
                                    <option value="tecnico">Técnico</option>
                                    <option value="licenciatura">Licenciatura</option>
                                    <option value="maestria">Maestría</option>
                                    <option value="doctorado">Doctorado</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Carrera Universitaria</label>
                                <input type="text" name="carrera_universitaria" class="form-control"
                                    placeholder="Nombre completo de la carrera universitaria">
                                <small class="form-hint">Especifica el nombre completo de tu carrera universitaria</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Institución</label>
                                <input type="text" name="institucion" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Año de Graduación</label>
                                <input type="number" name="anio_graduacion" class="form-control" min="1950" max="2099">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Mes Egresado SUNEDU</label>
                                <select name="mes_egresado_sunedu" class="form-select">
                                    <option value="">Seleccionar...</option>
                                    <option value="1">Enero</option>
                                    <option value="2">Febrero</option>
                                    <option value="3">Marzo</option>
                                    <option value="4">Abril</option>
                                    <option value="5">Mayo</option>
                                    <option value="6">Junio</option>
                                    <option value="7">Julio</option>
                                    <option value="8">Agosto</option>
                                    <option value="9">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                                <small class="form-hint">Mes de egreso registrado en SUNEDU</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Año Egresado SUNEDU</label>
                                <input type="number" name="anio_egresado_sunedu" class="form-control" min="1950" max="2099"
                                    placeholder="YYYY">
                                <small class="form-hint">Año de egreso registrado en SUNEDU</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Fotografía (JPG, PNG - Máx. 2MB)</label>
                                <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/jpg">
                                <small class="form-hint">Sube una fotografía reciente tipo carnet</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Experiencia y Habilidades</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Experiencia Laboral</label>
                        <textarea name="experiencia_laboral" class="form-control" rows="5"
                            placeholder="Describe tu experiencia laboral, puestos anteriores, empresas donde has trabajado, etc."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Habilidades</label>
                        <textarea name="habilidades" class="form-control" rows="3"
                            placeholder="Lista tus habilidades técnicas y blandas separadas por comas"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Curriculum Vitae (PDF, DOC, DOCX - Máx. 5MB)</label>
                        <input type="file" name="cv" class="form-control" accept=".pdf,.doc,.docx">
                        <small class="form-hint">Sube tu CV en formato PDF o Word</small>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="acepto" required>
                        <label class="form-check-label" for="acepto">
                            Acepto que la información proporcionada es verídica y autorizo el tratamiento de mis datos personales
                            conforme a la política de privacidad.
                        </label>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="<?= APP_URL ?>/convocatoria/<?= $convocatoria['id'] ?>" class="btn btn-link">Cancelar</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-send icon"></i> Enviar Postulación
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Perfil al que te postulas</h3>
            </div>
            <div class="card-body">
                <h4><?= htmlspecialchars($perfil['titulo']) ?></h4>
                <div class="mb-2">
                    <strong>Área:</strong> <?= htmlspecialchars($perfil['area_nombre']) ?>
                </div>
                <div class="mb-2">
                    <strong>Vacantes:</strong> <?= $perfil['vacantes'] ?>
                </div>
                <?php if ($perfil['experiencia_requerida'] > 0): ?>
                <div class="mb-2">
                    <strong>Experiencia:</strong> <?= $perfil['experiencia_requerida'] ?> años
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
$customScripts = <<<HTML
<script>
// Mostrar/ocultar campo de tipo de discapacidad
document.getElementById('presenta_discapacidad').addEventListener('change', function() {
    var tipoRow = document.getElementById('discapacidad_tipo_row');
    var tipoInput = document.getElementById('tipo_discapacidad');

    if (this.value === 'si') {
        tipoRow.style.display = 'block';
        tipoInput.required = true;
    } else {
        tipoRow.style.display = 'none';
        tipoInput.required = false;
        tipoInput.value = '';
    }
});
</script>
HTML;

$content = ob_get_clean();
require BASE_PATH . '/views/layouts/public.php';
?>
