<?php
require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/models/Convocatoria.php';
require_once BASE_PATH . '/models/Candidato.php';
require_once BASE_PATH . '/models/Postulacion.php';
require_once BASE_PATH . '/models/Carrera.php';

class PublicController extends Controller {

    public function index() {
        $convocatoriaModel = new Convocatoria();
        $convocatorias = $convocatoriaModel->getPublicadas();

        $this->view('public/index', compact('convocatorias'));
    }

    public function show($id) {
        $convocatoriaModel = new Convocatoria();
        $convocatoria = $convocatoriaModel->getById($id);

        if (!$convocatoria || $convocatoria['estado'] !== 'publicada') {
            $this->redirect('/');
        }

        $carreras = $convocatoriaModel->getCarreras($id);
        $this->view('public/detalle', compact('convocatoria', 'carreras'));
    }

    public function aplicar($id) {
        $convocatoriaModel = new Convocatoria();
        $convocatoria = $convocatoriaModel->getById($id);

        if (!$convocatoria || $convocatoria['estado'] !== 'publicada') {
            $this->redirect('/');
        }

        $carreraModel = new Carrera();
        $carreras = $carreraModel->getActive();

        $this->view('public/aplicar', compact('convocatoria', 'carreras'));
    }

    public function postular() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/');
        }

        $candidatoModel = new Candidato();
        $postulacionModel = new Postulacion();

        // Crear candidato
        $candidatoData = [
            'nombre' => $_POST['nombre'],
            'apellido_paterno' => $_POST['apellido_paterno'],
            'apellido_materno' => $_POST['apellido_materno'] ?? '',
            'email' => $_POST['email'],
            'telefono' => $_POST['telefono'] ?? '',
            'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? null,
            'direccion' => $_POST['direccion'] ?? '',
            'ciudad' => $_POST['ciudad'] ?? '',
            'estado' => $_POST['estado'] ?? '',
            'codigo_postal' => $_POST['codigo_postal'] ?? '',
            'carrera_id' => $_POST['carrera_id'] ?? null,
            'nivel_estudios' => $_POST['nivel_estudios'] ?? null,
            'institucion' => $_POST['institucion'] ?? '',
            'anio_graduacion' => $_POST['anio_graduacion'] ?? null,
            'experiencia_laboral' => $_POST['experiencia_laboral'] ?? '',
            'habilidades' => $_POST['habilidades'] ?? ''
        ];

        $candidatoId = $candidatoModel->create($candidatoData);

        // Subir CV si existe
        if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
            $cvPath = $candidatoModel->uploadCV($_FILES['cv'], $candidatoId);
            if ($cvPath) {
                $candidatoModel->update($candidatoId, ['cv_path' => $cvPath]);
            }
        }

        // Crear postulación
        $postulacionData = [
            'convocatoria_id' => $_POST['convocatoria_id'],
            'candidato_id' => $candidatoId,
            'estado' => 'pendiente'
        ];

        $postulacionModel->create($postulacionData);

        $_SESSION['success'] = 'Tu postulación ha sido enviada exitosamente';
        $this->redirect('/convocatoria/' . $_POST['convocatoria_id']);
    }
}
