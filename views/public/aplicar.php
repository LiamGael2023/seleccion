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
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label required">Nombre</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label required">Apellido Paterno</label>
                                <input type="text" name="apellido_paterno" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Apellido Materno</label>
                                <input type="text" name="apellido_materno" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label required">Email</label>
                                <input type="email" name="email" class="form-control" required>
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
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/public.php';
?>
