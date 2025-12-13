<?php
require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/models/CategoriaCarrera.php';

class CategoriaCarreraController extends Controller {

    public function __construct() {
        $this->requireAuth();
    }

    public function index() {
        $categoriaModel = new CategoriaCarrera();
        $categorias = $categoriaModel->getWithCarrerasCount();

        $this->view('admin/categorias_carreras/index', compact('categorias'));
    }

    public function create() {
        $this->view('admin/categorias_carreras/create');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/categorias-carreras');
        }

        $categoriaModel = new CategoriaCarrera();

        $data = [
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion'] ?? '',
            'orden' => $_POST['orden'] ?? 0,
            'activo' => isset($_POST['activo']) ? 1 : 0
        ];

        $categoriaModel->create($data);

        $_SESSION['success'] = 'Categoría creada exitosamente';
        $this->redirect('/admin/categorias-carreras');
    }

    public function edit($id) {
        $categoriaModel = new CategoriaCarrera();
        $categoria = $categoriaModel->getById($id);

        if (!$categoria) {
            $_SESSION['error'] = 'Categoría no encontrada';
            $this->redirect('/admin/categorias-carreras');
        }

        $this->view('admin/categorias_carreras/edit', compact('categoria'));
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/categorias-carreras');
        }

        $categoriaModel = new CategoriaCarrera();

        $data = [
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion'] ?? '',
            'orden' => $_POST['orden'] ?? 0,
            'activo' => isset($_POST['activo']) ? 1 : 0
        ];

        $categoriaModel->update($id, $data);

        $_SESSION['success'] = 'Categoría actualizada exitosamente';
        $this->redirect('/admin/categorias-carreras');
    }

    public function delete($id) {
        $categoriaModel = new CategoriaCarrera();

        try {
            $result = $categoriaModel->delete($id);

            if ($result) {
                $_SESSION['success'] = 'Categoría eliminada exitosamente';
            } else {
                $_SESSION['error'] = 'No se pudo eliminar la categoría';
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al eliminar la categoría: ' . $e->getMessage();
        }

        $this->redirect('/admin/categorias-carreras');
    }
}
