<?php
require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/models/NivelEstudio.php';

class NivelEstudioController extends Controller {

    public function __construct() {
        $this->requireAuth();
    }

    public function index() {
        $nivelModel = new NivelEstudio();
        $niveles = $nivelModel->getWithCarrerasCount();

        $this->view('admin/niveles_estudio/index', compact('niveles'));
    }

    public function create() {
        $this->view('admin/niveles_estudio/create');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/niveles-estudio');
        }

        $nivelModel = new NivelEstudio();

        $data = [
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion'] ?? '',
            'orden' => $_POST['orden'] ?? 0,
            'activo' => isset($_POST['activo']) ? 1 : 0
        ];

        $nivelModel->create($data);

        $_SESSION['success'] = 'Nivel de estudio creado exitosamente';
        $this->redirect('/admin/niveles-estudio');
    }

    public function edit($id) {
        $nivelModel = new NivelEstudio();
        $nivel = $nivelModel->getById($id);

        if (!$nivel) {
            $_SESSION['error'] = 'Nivel de estudio no encontrado';
            $this->redirect('/admin/niveles-estudio');
        }

        $this->view('admin/niveles_estudio/edit', compact('nivel'));
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/niveles-estudio');
        }

        $nivelModel = new NivelEstudio();

        $data = [
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion'] ?? '',
            'orden' => $_POST['orden'] ?? 0,
            'activo' => isset($_POST['activo']) ? 1 : 0
        ];

        $nivelModel->update($id, $data);

        $_SESSION['success'] = 'Nivel de estudio actualizado exitosamente';
        $this->redirect('/admin/niveles-estudio');
    }

    public function delete($id) {
        $nivelModel = new NivelEstudio();

        try {
            $result = $nivelModel->delete($id);

            if ($result) {
                $_SESSION['success'] = 'Nivel de estudio eliminado exitosamente';
            } else {
                $_SESSION['error'] = 'No se pudo eliminar el nivel de estudio';
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al eliminar el nivel de estudio: ' . $e->getMessage();
        }

        $this->redirect('/admin/niveles-estudio');
    }
}
