<?php
require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/models/Convocatoria.php';
require_once BASE_PATH . '/models/Candidato.php';
require_once BASE_PATH . '/models/Postulacion.php';

class DashboardController extends Controller {

    public function __construct() {
        $this->requireAuth();
    }

    public function index() {
        $convocatoriaModel = new Convocatoria();
        $candidatoModel = new Candidato();
        $postulacionModel = new Postulacion();

        $totalConvocatorias = count($convocatoriaModel->all());
        $totalCandidatos = count($candidatoModel->all());
        $totalPostulaciones = count($postulacionModel->all());
        $convocatorias = $convocatoriaModel->getAllWithDetails();

        $this->view('admin/dashboard', compact(
            'totalConvocatorias',
            'totalCandidatos',
            'totalPostulaciones',
            'convocatorias'
        ));
    }
}
