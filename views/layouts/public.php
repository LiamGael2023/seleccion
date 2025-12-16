<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title><?= $pageTitle ?? 'Inicio' ?> - <?= APP_NAME ?></title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS (includes Google Fonts) -->
    <link href="<?= APP_URL ?>/assets/css/custom.css" rel="stylesheet"/>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-glass sticky-top">
        <div class="container-xl">
            <a class="navbar-brand" href="<?= APP_URL ?>/">
                <i class="fas fa-landmark me-2"></i>
                <?= APP_NAME ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= APP_URL ?>/">
                            <i class="fas fa-home me-1"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= APP_URL ?>/login" class="btn btn-gradient-primary ms-lg-3">
                            <i class="fas fa-sign-in-alt me-1"></i>
                            Administración
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container-xl py-4">
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

            <?= $content ?? '' ?>
        </div>
    </main>

    <!-- Footer Institucional -->
    <footer class="footer-modern text-center">
        <div class="container-xl">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="mb-1">
                        <i class="fas fa-landmark me-2"></i>
                        <strong><?= APP_NAME ?></strong>
                    </p>
                    <p class="mb-0 opacity-75" style="font-size: 0.875rem;">
                        Sistema de Selección de Personal
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0">
                        &copy; <?= date('Y') ?> República del Perú
                    </p>
                    <p class="mb-0 opacity-75" style="font-size: 0.875rem;">
                        Todos los derechos reservados
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <?= $customScripts ?? '' ?>

    <script>
        // Add smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Initialize tooltips
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    </script>
</body>
</html>
