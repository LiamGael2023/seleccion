<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title><?= $pageTitle ?? 'Admin' ?> - <?= APP_NAME ?></title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS (includes Google Fonts) -->
    <link href="<?= APP_URL ?>/assets/css/custom.css" rel="stylesheet"/>
</head>
<body class="admin-layout">
    <!-- Admin Navbar -->
    <nav class="navbar navbar-expand-lg navbar-admin sticky-top">
        <div class="container-fluid">
            <button class="btn btn-sidebar-toggle me-3" type="button" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>

            <a class="navbar-brand" href="<?= APP_URL ?>/admin/dashboard">
                <i class="fas fa-shield-halved me-2"></i>
                <?= APP_NAME ?> <span class="badge bg-gradient-primary ms-2">Admin</span>
            </a>

            <div class="ms-auto d-flex align-items-center">
                <div class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle user-dropdown" data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user_name'] ?? 'User') ?>&background=667eea&color=fff&size=40" class="rounded-circle me-2" alt="Avatar">
                        <span class="d-none d-md-inline">
                            <strong><?= $_SESSION['user_name'] ?? 'Usuario' ?></strong>
                            <small class="d-block text-muted"><?= ucfirst($_SESSION['user_role'] ?? 'user') ?></small>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg">
                        <li><a class="dropdown-item" href="<?= APP_URL ?>/"><i class="fas fa-home me-2"></i> Ver Sitio</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="<?= APP_URL ?>/logout"><i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h5 class="mb-0"><i class="fas fa-th-large me-2"></i> Navegación</h5>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="<?= APP_URL ?>/admin/dashboard" class="sidebar-link">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="<?= APP_URL ?>/admin/convocatorias" class="sidebar-link">
                        <i class="fas fa-briefcase"></i>
                        <span>Convocatorias</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="<?= APP_URL ?>/admin/areas" class="sidebar-link">
                        <i class="fas fa-building"></i>
                        <span>Áreas</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="<?= APP_URL ?>/admin/carreras" class="sidebar-link">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Carreras</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content-admin">
            <?php if (isset($pageHeader)): ?>
            <div class="page-header-admin">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="page-title-admin">
                                <?= $pageHeader ?>
                            </h2>
                        </div>
                        <?php if (isset($pageActions)): ?>
                        <div class="col-auto">
                            <?= $pageActions ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <div class="container-fluid py-4">
                <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-modern alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="alert-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="alert-content">
                            <?= $_SESSION['success'] ?>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['success']); endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-modern alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="alert-icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div class="alert-content">
                            <?= $_SESSION['error'] ?>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['error']); endif; ?>

                <?= $content ?? '' ?>
            </div>
        </main>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <?= $customScripts ?? '' ?>

    <script>
        // Sidebar toggle
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar')?.classList.toggle('collapsed');
            document.querySelector('.main-content-admin')?.classList.toggle('sidebar-collapsed');
        });

        // Mark active nav link
        const currentPath = window.location.pathname;
        document.querySelectorAll('.sidebar-link').forEach(link => {
            if (link.getAttribute('href') === currentPath || currentPath.startsWith(link.getAttribute('href'))) {
                link.classList.add('active');
            }
        });

        // Initialize tooltips
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    </script>
</body>
</html>
