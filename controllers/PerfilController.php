<?php
require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/models/Perfil.php';
require_once BASE_PATH . '/models/Convocatoria.php';
require_once BASE_PATH . '/models/Area.php';
require_once BASE_PATH . '/models/Carrera.php';

class PerfilController extends Controller {

    public function __construct() {
        $this->requireAuth();
    }

    public function create($convocatoriaId) {
        $convocatoriaModel = new Convocatoria();
        $convocatoria = $convocatoriaModel->find($convocatoriaId);

        if (!$convocatoria) {
            $_SESSION['error'] = 'Convocatoria no encontrada';
            $this->redirect('/admin/convocatorias');
        }

        $areaModel = new Area();
        $carreraModel = new Carrera();

        $areas = $areaModel->getActive();
        $carreras = $carreraModel->getActive();

        $this->view('admin/perfiles/create', compact('convocatoria', 'areas', 'carreras'));
    }

    public function store($convocatoriaId) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/convocatorias/' . $convocatoriaId . '/perfiles');
        }

        $data = [
            'convocatoria_id' => $convocatoriaId,
            'titulo' => $_POST['titulo'],
            'area_id' => $_POST['area_id'],
            'descripcion' => $_POST['descripcion'],
            'requisitos' => $_POST['requisitos'],
            'responsabilidades' => $_POST['responsabilidades'] ?? '',
            'experiencia_requerida' => $_POST['experiencia_requerida'] ?? 0,
            'vacantes' => $_POST['vacantes'] ?? 1,
            'orden' => $_POST['orden'] ?? 0
        ];

        $perfilModel = new Perfil();
        $perfilId = $perfilModel->create($data);

        if ($perfilId && isset($_POST['carreras'])) {
            foreach ($_POST['carreras'] as $carreraId) {
                $perfilModel->addCarrera($perfilId, $carreraId);
            }
        }

        $_SESSION['success'] = 'Perfil creado exitosamente';
        $this->redirect('/admin/convocatorias/' . $convocatoriaId . '/perfiles');
    }

    public function edit($perfilId) {
        $perfilModel = new Perfil();
        $perfil = $perfilModel->find($perfilId);

        if (!$perfil) {
            $_SESSION['error'] = 'Perfil no encontrado';
            $this->redirect('/admin/convocatorias');
        }

        $convocatoriaModel = new Convocatoria();
        $convocatoria = $convocatoriaModel->find($perfil['convocatoria_id']);

        $areaModel = new Area();
        $carreraModel = new Carrera();

        $areas = $areaModel->getActive();
        $carreras = $carreraModel->getActive();
        $carrerasSeleccionadas = $perfilModel->getCarreras($perfilId);

        $carrerasIds = array_column($carrerasSeleccionadas, 'id');

        $this->view('admin/perfiles/edit', compact(
            'perfil',
            'convocatoria',
            'areas',
            'carreras',
            'carrerasIds'
        ));
    }

    public function update($perfilId) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/convocatorias');
        }

        $perfilModel = new Perfil();
        $perfil = $perfilModel->find($perfilId);

        if (!$perfil) {
            $_SESSION['error'] = 'Perfil no encontrado';
            $this->redirect('/admin/convocatorias');
        }

        $data = [
            'titulo' => $_POST['titulo'],
            'area_id' => $_POST['area_id'],
            'descripcion' => $_POST['descripcion'],
            'requisitos' => $_POST['requisitos'],
            'responsabilidades' => $_POST['responsabilidades'] ?? '',
            'experiencia_requerida' => $_POST['experiencia_requerida'] ?? 0,
            'vacantes' => $_POST['vacantes'] ?? 1,
            'orden' => $_POST['orden'] ?? 0
        ];

        $perfilModel->update($perfilId, $data);

        $perfilModel->removeAllCarreras($perfilId);
        if (isset($_POST['carreras'])) {
            foreach ($_POST['carreras'] as $carreraId) {
                $perfilModel->addCarrera($perfilId, $carreraId);
            }
        }

        $_SESSION['success'] = 'Perfil actualizado exitosamente';
        $this->redirect('/admin/convocatorias/' . $perfil['convocatoria_id'] . '/perfiles');
    }

    public function delete($perfilId) {
        $perfilModel = new Perfil();
        $perfil = $perfilModel->find($perfilId);

        if (!$perfil) {
            $_SESSION['error'] = 'Perfil no encontrado';
            $this->redirect('/admin/convocatorias');
        }

        $convocatoriaId = $perfil['convocatoria_id'];
        $perfilModel->delete($perfilId);

        $_SESSION['success'] = 'Perfil eliminado exitosamente';
        $this->redirect('/admin/convocatorias/' . $convocatoriaId . '/perfiles');
    }

    public function list($convocatoriaId) {
        $convocatoriaModel = new Convocatoria();
        $convocatoria = $convocatoriaModel->find($convocatoriaId);

        if (!$convocatoria) {
            $_SESSION['error'] = 'Convocatoria no encontrada';
            $this->redirect('/admin/convocatorias');
        }

        $perfilModel = new Perfil();
        $perfiles = $perfilModel->getByConvocatoria($convocatoriaId);

        // Obtener conteo de postulaciones por perfil
        foreach ($perfiles as &$perfil) {
            $perfil['total_postulaciones'] = $perfilModel->countPostulaciones($perfil['id']);
        }

        $this->view('admin/perfiles/index', compact('convocatoria', 'perfiles'));
    }

    public function postulaciones($perfilId) {
        $perfilModel = new Perfil();
        $perfil = $perfilModel->getById($perfilId);

        if (!$perfil) {
            $_SESSION['error'] = 'Perfil no encontrado';
            $this->redirect('/admin/convocatorias');
        }

        $convocatoriaModel = new Convocatoria();
        $convocatoria = $convocatoriaModel->find($perfil['convocatoria_id']);

        $postulaciones = $perfilModel->getPostulaciones($perfilId);

        $this->view('admin/perfiles/postulaciones', compact('perfil', 'convocatoria', 'postulaciones'));
    }
}
