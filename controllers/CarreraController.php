<?php
require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/models/Carrera.php';

class CarreraController extends Controller {

    public function __construct() {
        $this->requireAuth();
    }

    public function index() {
        $carreraModel = new Carrera();
        $carreras = $carreraModel->all('nombre', 'ASC');

        $this->view('admin/carreras/index', compact('carreras'));
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/carreras');
        }

        $data = [
            'nombre' => $_POST['nombre'],
            'nivel' => $_POST['nivel']
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
            'nivel' => $_POST['nivel']
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
