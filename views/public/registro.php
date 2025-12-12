<?php
$pageTitle = 'Registro de Postulante';
ob_start();
?>

<div class="page-header d-print-none mt-4">
    <div class="container-xl">
        <div class="row g-2 align-items-center justify-content-center">
            <div class="col-md-8 col-lg-6">
                <h2 class="page-title text-center">Crear Cuenta de Postulante</h2>
                <p class="text-muted text-center">Regístrate para postularte a nuestras convocatorias</p>
            </div>
        </div>
    </div>
</div>

<div class="container-xl mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <form id="formRegistro" method="post" action="<?= APP_URL ?>/postulante/registro">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Datos de Identificación</h3>
                    </div>
                    <div class="card-body">
                        <!-- DNI con búsqueda RENIEC -->
                        <div class="mb-3">
                            <label class="form-label required">DNI</label>
                            <div class="input-group">
                                <input type="text" id="dni" name="dni" class="form-control"
                                    placeholder="Ingrese su DNI" maxlength="8" pattern="[0-9]{8}" required>
                                <button type="button" id="btnBuscarDni" class="btn btn-primary">
                                    <i class="ti ti-search"></i> Buscar
                                </button>
                            </div>
                            <small class="form-hint">Ingrese su DNI y haga clic en Buscar para validar</small>
                            <div id="dniError" class="invalid-feedback d-block" style="display: none;"></div>
                        </div>

                        <!-- Nombres (autocompleta desde API) -->
                        <div class="mb-3">
                            <label class="form-label required">Nombres</label>
                            <input type="text" id="nombres" name="nombres" class="form-control" readonly required>
                            <small class="form-hint text-muted">Se completará automáticamente desde RENIEC</small>
                        </div>

                        <!-- Apellido Paterno (autocompleta desde API) -->
                        <div class="mb-3">
                            <label class="form-label required">Apellido Paterno</label>
                            <input type="text" id="apellido_paterno" name="apellido_paterno" class="form-control" readonly required>
                            <small class="form-hint text-muted">Se completará automáticamente desde RENIEC</small>
                        </div>

                        <!-- Apellido Materno (autocompleta desde API) -->
                        <div class="mb-3">
                            <label class="form-label required">Apellido Materno</label>
                            <input type="text" id="apellido_materno" name="apellido_materno" class="form-control" readonly required>
                            <small class="form-hint text-muted">Se completará automáticamente desde RENIEC</small>
                        </div>

                        <!-- Campos ocultos para datos adicionales de RENIEC -->
                        <input type="hidden" id="estado_reniec" name="estado_reniec">
                        <input type="hidden" id="condicion_reniec" name="condicion_reniec">
                        <input type="hidden" id="direccion" name="direccion">
                        <input type="hidden" id="ubigeo" name="ubigeo">
                        <input type="hidden" id="departamento" name="departamento">
                        <input type="hidden" id="provincia" name="provincia">
                        <input type="hidden" id="distrito" name="distrito">
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Datos de Acceso</h3>
                    </div>
                    <div class="card-body">
                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label required">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                placeholder="ejemplo@correo.com" required>
                            <small class="form-hint">Este será tu email para recibir notificaciones</small>
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-3">
                            <label class="form-label required">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control"
                                minlength="6" required>
                            <small class="form-hint">Mínimo 6 caracteres</small>
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div class="mb-3">
                            <label class="form-label required">Confirmar Contraseña</label>
                            <input type="password" name="password_confirm" id="password_confirm" class="form-control"
                                minlength="6" required>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="acepto_terminos" required>
                            <label class="form-check-label" for="acepto_terminos">
                                Acepto los términos y condiciones y autorizo el tratamiento de mis datos personales
                            </label>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="<?= APP_URL ?>/" class="btn btn-link">Cancelar</a>
                        <button type="submit" id="btnRegistrar" class="btn btn-primary" disabled>
                            <i class="ti ti-user-plus icon"></i> Crear Cuenta
                        </button>
                    </div>
                </div>
            </form>

            <div class="text-center mt-3">
                <p class="text-muted">
                    ¿Ya tienes cuenta?
                    <a href="<?= APP_URL ?>/postulante/login">Inicia sesión aquí</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php
$customScripts = <<<HTML
<script>
let datosReniecValidados = false;

// Buscar DNI en API de RENIEC
document.getElementById('btnBuscarDni').addEventListener('click', async function() {
    const dni = document.getElementById('dni').value.trim();
    const btnBuscar = this;
    const dniError = document.getElementById('dniError');

    // Validar formato DNI
    if (!/^\d{8}$/.test(dni)) {
        dniError.textContent = 'El DNI debe tener 8 dígitos';
        dniError.style.display = 'block';
        return;
    }

    // Deshabilitar botón y mostrar loading
    btnBuscar.disabled = true;
    btnBuscar.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Buscando...';
    dniError.style.display = 'none';

    try {
        // Llamar a la API de RENIEC
        const response = await fetch('https://api.apis.net.pe/v1/dni?numero=' + dni);

        if (!response.ok) {
            throw new Error('No se pudo obtener los datos del DNI');
        }

        const data = await response.json();

        // Validar que se obtuvieron datos
        if (!data.nombres || !data.apellidoPaterno) {
            throw new Error('DNI no encontrado en RENIEC');
        }

        // Llenar campos con datos de RENIEC
        document.getElementById('nombres').value = data.nombres || '';
        document.getElementById('apellido_paterno').value = data.apellidoPaterno || '';
        document.getElementById('apellido_materno').value = data.apellidoMaterno || '';

        // Campos ocultos
        document.getElementById('estado_reniec').value = data.estado || '';
        document.getElementById('condicion_reniec').value = data.condicion || '';
        document.getElementById('direccion').value = data.direccion || '';
        document.getElementById('ubigeo').value = data.ubigeo || '';
        document.getElementById('departamento').value = data.departamento || '';
        document.getElementById('provincia').value = data.provincia || '';
        document.getElementById('distrito').value = data.distrito || '';

        // Marcar como validado
        datosReniecValidados = true;
        document.getElementById('btnRegistrar').disabled = false;

        // Mostrar mensaje de éxito
        btnBuscar.innerHTML = '<i class="ti ti-check"></i> Datos encontrados';
        btnBuscar.classList.remove('btn-primary');
        btnBuscar.classList.add('btn-success');

        // Focus en email
        document.getElementById('email').focus();

    } catch (error) {
        dniError.textContent = error.message || 'Error al consultar DNI. Verifique el número ingresado.';
        dniError.style.display = 'block';
        datosReniecValidados = false;
        document.getElementById('btnRegistrar').disabled = true;

        // Limpiar campos
        document.getElementById('nombres').value = '';
        document.getElementById('apellido_paterno').value = '';
        document.getElementById('apellido_materno').value = '';
    } finally {
        if (!datosReniecValidados) {
            btnBuscar.disabled = false;
            btnBuscar.innerHTML = '<i class="ti ti-search"></i> Buscar';
        }
    }
});

// Validar contraseñas coincidan
document.getElementById('formRegistro').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const passwordConfirm = document.getElementById('password_confirm').value;

    if (!datosReniecValidados) {
        e.preventDefault();
        alert('Debe validar su DNI con el botón Buscar antes de continuar');
        return false;
    }

    if (password !== passwordConfirm) {
        e.preventDefault();
        alert('Las contraseñas no coinciden');
        document.getElementById('password_confirm').focus();
        return false;
    }

    return true;
});

// Resetear validación si cambia el DNI
document.getElementById('dni').addEventListener('input', function() {
    const btnBuscar = document.getElementById('btnBuscar');
    btnBuscar.disabled = false;
    btnBuscar.innerHTML = '<i class="ti ti-search"></i> Buscar';
    btnBuscar.classList.remove('btn-success');
    btnBuscar.classList.add('btn-primary');
    datosReniecValidados = false;
    document.getElementById('btnRegistrar').disabled = true;

    // Limpiar campos
    document.getElementById('nombres').value = '';
    document.getElementById('apellido_paterno').value = '';
    document.getElementById('apellido_materno').value = '';
});
</script>
HTML;

$content = ob_get_clean();
require BASE_PATH . '/views/layouts/public.php';
?>
