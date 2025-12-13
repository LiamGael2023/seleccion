<?php
require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/models/Convocatoria.php';
require_once BASE_PATH . '/models/Perfil.php';
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

        $perfilModel = new Perfil();
        $perfiles = $perfilModel->getByConvocatoria($id);

        // Obtener carreras para cada perfil
        foreach ($perfiles as &$perfil) {
            $perfil['carreras'] = $perfilModel->getCarreras($perfil['id']);
        }

        // Verificar si el usuario ya se postuló a esta convocatoria
        $postulacionExistente = false;
        if (isset($_SESSION['postulante_id'])) {
            $postulacionModel = new Postulacion();
            $postulacionExistente = $postulacionModel->tienePostulacionEnConvocatoria(
                $id,
                $_SESSION['postulante_id']
            );
        }

        $this->view('public/detalle', compact('convocatoria', 'perfiles', 'postulacionExistente'));
    }

    public function aplicar($perfilId) {
        // Verificar que el postulante esté autenticado
        if (!isset($_SESSION['postulante_id'])) {
            $_SESSION['error'] = 'Debes iniciar sesión para postularte';
            $_SESSION['return_url'] = '/perfil/' . $perfilId . '/aplicar';
            $this->redirect('/postulante/login');
        }

        $perfilModel = new Perfil();
        $perfil = $perfilModel->getById($perfilId);

        if (!$perfil) {
            $this->redirect('/');
        }

        $convocatoriaModel = new Convocatoria();
        $convocatoria = $convocatoriaModel->getById($perfil['convocatoria_id']);

        if (!$convocatoria || $convocatoria['estado'] !== 'publicada') {
            $this->redirect('/');
        }

        // Verificar si ya se postuló a algún perfil de esta convocatoria
        $postulacionModel = new Postulacion();
        $postulacionExistente = $postulacionModel->tienePostulacionEnConvocatoria(
            $perfil['convocatoria_id'],
            $_SESSION['postulante_id']
        );

        if ($postulacionExistente) {
            $_SESSION['error'] = 'Ya te postulaste al perfil "' . $postulacionExistente['perfil_titulo'] .
                                 '" de esta convocatoria. Solo puedes postularte a un perfil por convocatoria.';
            $this->redirect('/convocatoria/' . $perfil['convocatoria_id']);
        }

        $carreras = $perfilModel->getCarreras($perfilId);
        $carreraModel = new Carrera();
        $todasCarreras = $carreraModel->getActive();

        // Pasar datos del postulante al formulario
        $postulante = [
            'nombres' => $_SESSION['postulante_nombres'] ?? '',
            'apellido_paterno' => $_SESSION['postulante_apellido_paterno'] ?? '',
            'apellido_materno' => $_SESSION['postulante_apellido_materno'] ?? '',
            'email' => $_SESSION['postulante_email'] ?? ''
        ];

        $this->view('public/aplicar', compact('convocatoria', 'perfil', 'carreras', 'todasCarreras', 'postulante'));
    }

    public function postular() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/');
        }

        // Verificar que el postulante esté autenticado
        if (!isset($_SESSION['postulante_id'])) {
            $_SESSION['error'] = 'Debes iniciar sesión para postularte';
            $this->redirect('/postulante/login');
        }

        $candidatoModel = new Candidato();
        $postulacionModel = new Postulacion();

        // Verificar si ya se postuló a algún perfil de esta convocatoria
        $postulacionExistente = $postulacionModel->tienePostulacionEnConvocatoria(
            $_POST['convocatoria_id'],
            $_SESSION['postulante_id']
        );

        if ($postulacionExistente) {
            $_SESSION['error'] = 'Ya te postulaste al perfil "' . $postulacionExistente['perfil_titulo'] .
                                 '" de esta convocatoria. Solo puedes postularte a un perfil por convocatoria.';
            $this->redirect('/convocatoria/' . $_POST['convocatoria_id']);
        }

        // Crear candidato vinculado al usuario postulante
        // Los datos de nombre, apellido y email se toman de la sesión
        $candidatoData = [
            'usuario_postulante_id' => $_SESSION['postulante_id'],
            'nombre' => $_SESSION['postulante_nombres'],
            'apellido_paterno' => $_SESSION['postulante_apellido_paterno'],
            'apellido_materno' => $_SESSION['postulante_apellido_materno'] ?? '',
            'email' => $_SESSION['postulante_email'],
            'telefono' => $_POST['telefono'] ?? '',
            'fecha_nacimiento' => !empty($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : null,
            'sexo' => !empty($_POST['sexo']) ? $_POST['sexo'] : null,
            'presenta_discapacidad' => $_POST['presenta_discapacidad'] ?? 'no',
            'tipo_discapacidad' => ($_POST['presenta_discapacidad'] === 'si') ? ($_POST['tipo_discapacidad'] ?? null) : null,
            'direccion' => $_POST['direccion'] ?? '',
            'ciudad' => $_POST['ciudad'] ?? '',
            'estado' => $_POST['estado'] ?? '',
            'codigo_postal' => $_POST['codigo_postal'] ?? '',
            'carrera_id' => !empty($_POST['carrera_id']) ? $_POST['carrera_id'] : null,
            'carrera_universitaria' => !empty($_POST['carrera_universitaria']) ? $_POST['carrera_universitaria'] : null,
            'nivel_estudios' => !empty($_POST['nivel_estudios']) ? $_POST['nivel_estudios'] : null,
            'institucion' => $_POST['institucion'] ?? '',
            'anio_graduacion' => !empty($_POST['anio_graduacion']) ? $_POST['anio_graduacion'] : null,
            'mes_egresado_sunedu' => !empty($_POST['mes_egresado_sunedu']) ? $_POST['mes_egresado_sunedu'] : null,
            'anio_egresado_sunedu' => !empty($_POST['anio_egresado_sunedu']) ? $_POST['anio_egresado_sunedu'] : null,
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

        // Subir foto si existe
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $fotoPath = $candidatoModel->uploadFoto($_FILES['foto'], $candidatoId);
            if ($fotoPath) {
                $candidatoModel->update($candidatoId, ['foto_path' => $fotoPath]);
            }
        }

        // Crear postulación
        $postulacionData = [
            'convocatoria_id' => $_POST['convocatoria_id'],
            'perfil_id' => $_POST['perfil_id'],
            'candidato_id' => $candidatoId,
            'estado' => 'pendiente'
        ];

        $postulacionModel->create($postulacionData);

        $_SESSION['success'] = 'Tu postulación ha sido enviada exitosamente';
        $this->redirect('/convocatoria/' . $_POST['convocatoria_id']);
    }
}
