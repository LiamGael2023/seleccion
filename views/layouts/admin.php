<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title><?= $pageTitle ?? 'Admin' ?> - <?= APP_NAME ?></title>
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
        /* Estilos personalizados para la navbar */
        .navbar.custom-navbar {
            background: linear-gradient(135deg, #066fd1 0%, #0a8fff 100%) !important;
            box-shadow: 0 2px 8px rgba(6, 111, 209, 0.3);
        }
        .navbar.custom-navbar .navbar-brand a,
        .navbar.custom-navbar .nav-link,
        .navbar.custom-navbar .nav-link-title {
            color: #ffffff !important;
        }
        .navbar.custom-navbar .nav-link:hover,
        .navbar.custom-navbar .nav-link:focus {
            color: #e8f4ff !important;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }
        .navbar.custom-navbar .nav-link-icon i {
            color: #ffffff !important;
        }
        .navbar.custom-navbar .dropdown-toggle {
            color: #ffffff !important;
        }
        .navbar.custom-navbar .navbar-toggler-icon {
            filter: brightness(0) invert(1);
        }
        .navbar.custom-navbar .text-muted {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        .navbar.custom-navbar .text-reset {
            color: #ffffff !important;
        }
    </style>
</head>
<body>
    <div class="page">
        <!-- Navbar -->
        <header class="navbar navbar-expand-md custom-navbar d-print-none">
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href="<?= APP_URL ?>/admin/dashboard">
                        <?= APP_NAME ?>
                    </a>
                </h1>
                <div class="navbar-nav flex-row order-md-last">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown">
                            <span class="avatar avatar-sm" style="background-image: url(https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user_name'] ?? 'User') ?>&background=random)"></span>
                            <div class="d-none d-xl-block ps-2">
                                <div><?= $_SESSION['user_name'] ?? 'Usuario' ?></div>
                                <div class="mt-1 small text-muted"><?= ucfirst($_SESSION['user_role'] ?? 'user') ?></div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <a href="<?= APP_URL ?>/logout" class="dropdown-item">Cerrar sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="navbar-expand-md">
            <div class="collapse navbar-collapse" id="navbar-menu">
                <div class="navbar custom-navbar">
                    <div class="container-xl">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="<?= APP_URL ?>/admin/dashboard">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="ti ti-home"></i>
                                    </span>
                                    <span class="nav-link-title">Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= APP_URL ?>/admin/convocatorias">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="ti ti-briefcase"></i>
                                    </span>
                                    <span class="nav-link-title">Convocatorias</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= APP_URL ?>/admin/areas">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="ti ti-building"></i>
                                    </span>
                                    <span class="nav-link-title">Áreas</span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#navbar-carreras" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="ti ti-school"></i>
                                    </span>
                                    <span class="nav-link-title">Carreras</span>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="<?= APP_URL ?>/admin/carreras">
                                        <i class="ti ti-list icon"></i> Gestión de Carreras
                                    </a>
                                    <a class="dropdown-item" href="<?= APP_URL ?>/admin/categorias-carreras">
                                        <i class="ti ti-folders icon"></i> Categorías
                                    </a>
                                    <a class="dropdown-item" href="<?= APP_URL ?>/admin/niveles-estudio">
                                        <i class="ti ti-certificate icon"></i> Niveles de Estudio
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-wrapper">
            <!-- Page header -->
            <?php if (isset($pageHeader)): ?>
            <div class="page-header d-print-none">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <h2 class="page-title"><?= $pageHeader ?></h2>
                        </div>
                        <?php if (isset($pageActions)): ?>
                        <div class="col-auto ms-auto d-print-none">
                            <?= $pageActions ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Page body -->
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
