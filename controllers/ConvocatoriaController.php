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
        $this->view('admin/convocatorias/create');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/convocatorias');
        }

        $data = [
            'titulo' => $_POST['titulo'],
            'descripcion' => $_POST['descripcion'] ?? '',
            'salario_min' => $_POST['salario_min'] ?? null,
            'salario_max' => $_POST['salario_max'] ?? null,
            'tipo_contrato' => $_POST['tipo_contrato'],
            'fecha_inicio' => $_POST['fecha_inicio'],
            'fecha_cierre' => $_POST['fecha_cierre'],
            'estado' => $_POST['estado'] ?? 'borrador',
            'usuario_id' => $_SESSION['user_id']
        ];

        $convocatoriaModel = new Convocatoria();
        $convocatoriaId = $convocatoriaModel->create($data);

        $_SESSION['success'] = 'Convocatoria creada exitosamente. Ahora puedes agregar perfiles a esta convocatoria.';
        $this->redirect('/admin/convocatorias/' . $convocatoriaId . '/perfiles');
    }

    public function edit($id) {
        $convocatoriaModel = new Convocatoria();
        $convocatoria = $convocatoriaModel->find($id);

        $this->view('admin/convocatorias/edit', compact('convocatoria'));
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/convocatorias');
        }

        $data = [
            'titulo' => $_POST['titulo'],
            'descripcion' => $_POST['descripcion'] ?? '',
            'salario_min' => $_POST['salario_min'] ?? null,
            'salario_max' => $_POST['salario_max'] ?? null,
            'tipo_contrato' => $_POST['tipo_contrato'],
            'fecha_inicio' => $_POST['fecha_inicio'],
            'fecha_cierre' => $_POST['fecha_cierre'],
            'estado' => $_POST['estado'] ?? 'borrador'
        ];

        $convocatoriaModel = new Convocatoria();
        $convocatoriaModel->update($id, $data);

        $_SESSION['success'] = 'Convocatoria actualizada exitosamente';
        $this->redirect('/admin/convocatorias');
    }

    public function delete($id) {
        $convocatoriaModel = new Convocatoria();

        try {
            $result = $convocatoriaModel->delete($id);

            if ($result) {
                $_SESSION['success'] = 'Convocatoria eliminada exitosamente';
            } else {
                $_SESSION['error'] = 'No se pudo eliminar la convocatoria';
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al eliminar la convocatoria: ' . $e->getMessage();
        }

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
