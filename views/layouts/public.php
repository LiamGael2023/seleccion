<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title><?= $pageTitle ?? 'Inicio' ?> - <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta19/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet"/>
    <style>
        @import url('https://rsms.me/inter/inter.css');
        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }
        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>
<body>
    <div class="page">
        <!-- Navbar -->
        <header class="navbar navbar-expand-md navbar-light d-print-none">
            <div class="container-xl">
                <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href="<?= APP_URL ?>/">
                        <?= APP_NAME ?>
                    </a>
                </h1>
                <div class="navbar-nav flex-row order-md-last">
                    <?php if (isset($_SESSION['postulante_id'])): ?>
                        <!-- Usuario autenticado -->
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown">
                                <span class="avatar avatar-sm" style="background-image: url(https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['postulante_nombre_completo'] ?? 'User') ?>&background=066fd1&color=fff)"></span>
                                <div class="d-none d-xl-block ps-2">
                                    <div><?= $_SESSION['postulante_nombre_completo'] ?? 'Postulante' ?></div>
                                    <div class="mt-1 small text-muted">Postulante</div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <a href="<?= APP_URL ?>/postulante/logout" class="dropdown-item">
                                    <i class="ti ti-logout icon"></i> Cerrar sesión
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Usuario no autenticado -->
                        <a href="<?= APP_URL ?>/postulante/registro" class="btn btn-outline-primary me-2">
                            <i class="ti ti-user-plus icon"></i>
                            Registrarse
                        </a>
                        <a href="<?= APP_URL ?>/postulante/login" class="btn btn-primary me-2">
                            <i class="ti ti-login icon"></i>
                            Iniciar Sesión
                        </a>
                        <a href="<?= APP_URL ?>/login" class="btn btn-secondary">
                            <i class="ti ti-shield-lock icon"></i>
                            Admin
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <div class="page-wrapper">
            <div class="page-body">
                <div class="container-xl">
                    <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <div class="d-flex">
                            <div><i class="ti ti-check icon alert-icon"></i></div>
                            <div><?= $_SESSION['success'] ?></div>
                        </div>
                        <a class="btn-close" data-bs-dismiss="alert"></a>
                    </div>
                    <?php unset($_SESSION['success']); endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <div class="d-flex">
                            <div><i class="ti ti-alert-circle icon alert-icon"></i></div>
                            <div><?= $_SESSION['error'] ?></div>
                        </div>
                        <a class="btn-close" data-bs-dismiss="alert"></a>
                    </div>
                    <?php unset($_SESSION['error']); endif; ?>

                    <?= $content ?? '' ?>
                </div>
            </div>

            <footer class="footer footer-transparent d-print-none">
                <div class="container-xl">
                    <div class="row text-center align-items-center">
                        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    Copyright &copy; <?= date('Y') ?> <?= APP_NAME ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta19/dist/js/tabler.min.js"></script>
    <?= $customScripts ?? '' ?>
</body>
</html>
