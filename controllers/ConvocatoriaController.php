<?php
require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/models/Convocatoria.php';
require_once BASE_PATH . '/models/Area.php';
require_once BASE_PATH . '/models/Carrera.php';
require_once BASE_PATH . '/models/ConvocatoriaAnexo.php';

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

        // Obtener anexos de la convocatoria
        $anexoModel = new ConvocatoriaAnexo();
        $anexos = $anexoModel->getByConvocatoria($id);

        $this->view('admin/convocatorias/edit', compact('convocatoria', 'anexos'));
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

    /**
     * Subir anexo a una convocatoria
     */
    public function subirAnexo($convocatoriaId) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Método no permitido';
            $this->redirect('/admin/convocatorias/' . $convocatoriaId . '/edit');
        }

        // Verificar que se subió un archivo
        if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['error'] = 'Error al subir el archivo';
            $this->redirect('/admin/convocatorias/' . $convocatoriaId . '/edit');
        }

        $anexoModel = new ConvocatoriaAnexo();

        // Guardar archivo
        $resultado = $anexoModel->guardarArchivo($_FILES['archivo'], $convocatoriaId);

        if (!$resultado['success']) {
            $_SESSION['error'] = $resultado['error'];
            $this->redirect('/admin/convocatorias/' . $convocatoriaId . '/edit');
        }

        // Guardar en base de datos
        $data = [
            'convocatoria_id' => $convocatoriaId,
            'nombre_original' => $resultado['nombre_original'],
            'nombre_archivo' => $resultado['nombre_archivo'],
            'ruta_archivo' => $resultado['ruta_archivo'],
            'tamanio' => $resultado['tamanio'],
            'descripcion' => $_POST['descripcion'] ?? '',
            'orden' => $_POST['orden'] ?? 0,
            'obligatorio' => isset($_POST['obligatorio']) ? 1 : 0
        ];

        $anexoId = $anexoModel->create($data);

        if ($anexoId) {
            $_SESSION['success'] = 'Anexo subido exitosamente';
        } else {
            $_SESSION['error'] = 'Error al guardar el anexo en la base de datos';
        }

        $this->redirect('/admin/convocatorias/' . $convocatoriaId . '/edit');
    }

    /**
     * Eliminar anexo
     */
    public function eliminarAnexo($convocatoriaId, $anexoId) {
        $anexoModel = new ConvocatoriaAnexo();

        if ($anexoModel->delete($anexoId)) {
            $_SESSION['success'] = 'Anexo eliminado exitosamente';
        } else {
            $_SESSION['error'] = 'Error al eliminar el anexo';
        }

        $this->redirect('/admin/convocatorias/' . $convocatoriaId . '/edit');
    }

    /**
     * Descargar anexo (público)
     */
    public function descargarAnexo($anexoId) {
        $anexoModel = new ConvocatoriaAnexo();
        $anexo = $anexoModel->find($anexoId);

        if (!$anexo) {
            http_response_code(404);
            die('Anexo no encontrado');
        }

        $rutaCompleta = BASE_PATH . '/' . $anexo['ruta_archivo'];

        if (!file_exists($rutaCompleta)) {
            http_response_code(404);
            die('Archivo no encontrado');
        }

        // Enviar headers para descarga
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $anexo['nombre_original'] . '"');
        header('Content-Length: ' . filesize($rutaCompleta));
        header('Cache-Control: no-cache, must-revalidate');
        header('Pragma: public');

        // Limpiar buffer y enviar archivo
        ob_clean();
        flush();
        readfile($rutaCompleta);
        exit;
    }
}
