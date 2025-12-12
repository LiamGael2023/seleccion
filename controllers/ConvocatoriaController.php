<?php
require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/models/Convocatoria.php';
require_once BASE_PATH . '/models/Area.php';
require_once BASE_PATH . '/models/Carrera.php';

class ConvocatoriaController extends Controller {

    public function __construct() {
        $this->requireAuth();
    }

    public function index() {
        $convocatoriaModel = new Convocatoria();
        $convocatorias = $convocatoriaModel->getAllWithDetails();

        $this->view('admin/convocatorias/index', compact('convocatorias'));
    }

    public function create() {
        $areaModel = new Area();
        $carreraModel = new Carrera();

        $areas = $areaModel->getActive();
        $carreras = $carreraModel->getActive();

        $this->view('admin/convocatorias/create', compact('areas', 'carreras'));
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/convocatorias');
        }

        $data = [
            'titulo' => $_POST['titulo'],
            'area_id' => $_POST['area_id'],
            'descripcion' => $_POST['descripcion'],
            'requisitos' => $_POST['requisitos'],
            'responsabilidades' => $_POST['responsabilidades'] ?? '',
            'salario_min' => $_POST['salario_min'] ?? null,
            'salario_max' => $_POST['salario_max'] ?? null,
            'tipo_contrato' => $_POST['tipo_contrato'],
            'experiencia_requerida' => $_POST['experiencia_requerida'] ?? 0,
            'fecha_inicio' => $_POST['fecha_inicio'],
            'fecha_cierre' => $_POST['fecha_cierre'],
            'vacantes' => $_POST['vacantes'] ?? 1,
            'estado' => $_POST['estado'] ?? 'borrador',
            'usuario_id' => $_SESSION['user_id']
        ];

        $convocatoriaModel = new Convocatoria();
        $convocatoriaId = $convocatoriaModel->create($data);

        if ($convocatoriaId && isset($_POST['carreras'])) {
            foreach ($_POST['carreras'] as $carreraId) {
                $convocatoriaModel->addCarrera($convocatoriaId, $carreraId);
            }
        }

        $_SESSION['success'] = 'Convocatoria creada exitosamente';
        $this->redirect('/admin/convocatorias');
    }

    public function edit($id) {
        $convocatoriaModel = new Convocatoria();
        $areaModel = new Area();
        $carreraModel = new Carrera();

        $convocatoria = $convocatoriaModel->find($id);
        $areas = $areaModel->getActive();
        $carreras = $carreraModel->getActive();
        $carrerasSeleccionadas = $convocatoriaModel->getCarreras($id);

        $carrerasIds = array_column($carrerasSeleccionadas, 'id');

        $this->view('admin/convocatorias/edit', compact(
            'convocatoria',
            'areas',
            'carreras',
            'carrerasIds'
        ));
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/convocatorias');
        }

        $data = [
            'titulo' => $_POST['titulo'],
            'area_id' => $_POST['area_id'],
            'descripcion' => $_POST['descripcion'],
            'requisitos' => $_POST['requisitos'],
            'responsabilidades' => $_POST['responsabilidades'] ?? '',
            'salario_min' => $_POST['salario_min'] ?? null,
            'salario_max' => $_POST['salario_max'] ?? null,
            'tipo_contrato' => $_POST['tipo_contrato'],
            'experiencia_requerida' => $_POST['experiencia_requerida'] ?? 0,
            'fecha_inicio' => $_POST['fecha_inicio'],
            'fecha_cierre' => $_POST['fecha_cierre'],
            'vacantes' => $_POST['vacantes'] ?? 1,
            'estado' => $_POST['estado'] ?? 'borrador'
        ];

        $convocatoriaModel = new Convocatoria();
        $convocatoriaModel->update($id, $data);

        $convocatoriaModel->removeAllCarreras($id);
        if (isset($_POST['carreras'])) {
            foreach ($_POST['carreras'] as $carreraId) {
                $convocatoriaModel->addCarrera($id, $carreraId);
            }
        }

        $_SESSION['success'] = 'Convocatoria actualizada exitosamente';
        $this->redirect('/admin/convocatorias');
    }

    public function delete($id) {
        $convocatoriaModel = new Convocatoria();
        $convocatoriaModel->delete($id);

        $_SESSION['success'] = 'Convocatoria eliminada exitosamente';
        $this->redirect('/admin/convocatorias');
    }

    public function postulaciones($id) {
        $convocatoriaModel = new Convocatoria();
        $convocatoria = $convocatoriaModel->getById($id);
        $postulaciones = $convocatoriaModel->getPostulaciones($id);

        $this->view('admin/convocatorias/postulaciones', compact('convocatoria', 'postulaciones'));
    }

    public function updatePostulacion() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false], 400);
        }

        $postulacionModel = new Postulacion();
        $data = [
            'estado' => $_POST['estado'],
            'puntuacion' => $_POST['puntuacion'] ?? 0,
            'comentarios' => $_POST['comentarios'] ?? ''
        ];

        $result = $postulacionModel->update($_POST['id'], $data);
        $this->json(['success' => $result]);
    }
}
