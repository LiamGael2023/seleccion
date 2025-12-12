<?php
$pageTitle = 'Iniciar Sesión - Postulante';
ob_start();
?>

<div class="page-header d-print-none mt-4">
    <div class="container-xl">
        <div class="row g-2 align-items-center justify-content-center">
            <div class="col-md-6 col-lg-4">
                <h2 class="page-title text-center">Iniciar Sesión</h2>
                <p class="text-muted text-center">Accede a tu cuenta de postulante</p>
            </div>
        </div>
    </div>
</div>

<div class="container-xl mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <form method="post" action="<?= APP_URL ?>/postulante/login">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label required">DNI</label>
                            <input type="text" name="dni" class="form-control"
                                placeholder="Ingrese su DNI" maxlength="8" pattern="[0-9]{8}"
                                value="<?= $_POST['dni'] ?? '' ?>" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">Contraseña</label>
                            <input type="password" name="password" class="form-control"
                                placeholder="Ingrese su contraseña" required>
                        </div>

                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ti ti-login icon"></i> Iniciar Sesión
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="text-center mt-3">
                <p class="text-muted">
                    ¿No tienes cuenta?
                    <a href="<?= APP_URL ?>/postulante/registro">Regístrate aquí</a>
                </p>
            </div>

            <div class="text-center mt-2">
                <a href="<?= APP_URL ?>/" class="text-muted">
                    <i class="ti ti-arrow-left"></i> Volver al inicio
                </a>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/public.php';
?>
