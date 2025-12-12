<?php
require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/models/Area.php';

class AreaController extends Controller {

    public function __construct() {
        $this->requireAuth();
    }

    public function index() {
        $areaModel = new Area();
        $areas = $areaModel->all('nombre', 'ASC');

        $this->view('admin/areas/index', compact('areas'));
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/areas');
        }

        $data = [
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion'] ?? ''
        ];

        $areaModel = new Area();
        $areaModel->create($data);

        $_SESSION['success'] = 'Área creada exitosamente';
        $this->redirect('/admin/areas');
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/areas');
        }

        $data = [
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion'] ?? ''
        ];

        $areaModel = new Area();
        $areaModel->update($id, $data);

        $_SESSION['success'] = 'Área actualizada exitosamente';
        $this->redirect('/admin/areas');
    }

    public function delete($id) {
        $areaModel = new Area();
        $areaModel->delete($id);

        $_SESSION['success'] = 'Área eliminada exitosamente';
        $this->redirect('/admin/areas');
    }
}
