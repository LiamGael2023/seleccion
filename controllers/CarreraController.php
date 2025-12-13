<?php
require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/models/Carrera.php';
require_once BASE_PATH . '/models/CategoriaCarrera.php';
require_once BASE_PATH . '/models/NivelEstudio.php';

class CarreraController extends Controller {

    public function __construct() {
        $this->requireAuth();
    }

    public function index() {
        $carreraModel = new Carrera();
        $categoriaModel = new CategoriaCarrera();
        $nivelModel = new NivelEstudio();

        $carreras = $carreraModel->getAllWithCategoria();
        $categorias = $categoriaModel->getActive();
        $niveles = $nivelModel->getActive();

        $this->view('admin/carreras/index', compact('carreras', 'categorias', 'niveles'));
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/carreras');
        }

        $data = [
            'nombre' => $_POST['nombre'],
            'nivel_id' => !empty($_POST['nivel_id']) ? $_POST['nivel_id'] : null,
            'categoria_id' => !empty($_POST['categoria_id']) ? $_POST['categoria_id'] : null
        ];

        $carreraModel = new Carrera();
        $carreraModel->create($data);

        $_SESSION['success'] = 'Carrera creada exitosamente';
        $this->redirect('/admin/carreras');
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/carreras');
        }

        $data = [
            'nombre' => $_POST['nombre'],
            'nivel_id' => !empty($_POST['nivel_id']) ? $_POST['nivel_id'] : null,
            'categoria_id' => !empty($_POST['categoria_id']) ? $_POST['categoria_id'] : null
        ];

        $carreraModel = new Carrera();
        $carreraModel->update($id, $data);

        $_SESSION['success'] = 'Carrera actualizada exitosamente';
        $this->redirect('/admin/carreras');
    }

    public function delete($id) {
        $carreraModel = new Carrera();
        $carreraModel->delete($id);

        $_SESSION['success'] = 'Carrera eliminada exitosamente';
        $this->redirect('/admin/carreras');
    }
}
