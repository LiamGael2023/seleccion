<?php
require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/models/UsuarioPostulante.php';

class PostulanteAuthController extends Controller {

    /**
     * Mostrar formulario de registro
     */
    public function registro() {
        // Si ya está logueado, redirigir a inicio
        if (isset($_SESSION['postulante_id'])) {
            $this->redirect('/');
        }

        $this->view('public/registro');
    }

    /**
     * Procesar registro de nuevo postulante
     */
    public function registroPost() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/postulante/registro');
        }

        $usuarioModel = new UsuarioPostulante();

        // Validar DNI
        $dni = $_POST['dni'] ?? '';
        if (!preg_match('/^\d{8}$/', $dni)) {
            $_SESSION['error'] = 'El DNI debe tener 8 dígitos';
            $this->redirect('/postulante/registro');
        }

        // Validar que el DNI no esté registrado
        if ($usuarioModel->dniExists($dni)) {
            $_SESSION['error'] = 'Este DNI ya está registrado. Por favor inicia sesión.';
            $this->redirect('/postulante/login');
        }

        // Validar email
        $email = $_POST['email'] ?? '';
        if (empty($email)) {
            $_SESSION['error'] = 'El email es requerido';
            $this->redirect('/postulante/registro');
        }

        // Validar que el email no esté registrado
        if ($usuarioModel->emailExists($email)) {
            $_SESSION['error'] = 'Este email ya está registrado. Por favor usa otro email.';
            $this->redirect('/postulante/registro');
        }

        // Validar contraseñas coincidan
        if ($_POST['password'] !== $_POST['password_confirm']) {
            $_SESSION['error'] = 'Las contraseñas no coinciden';
            $this->redirect('/postulante/registro');
        }

        // Crear usuario
        $data = [
            'dni' => $dni,
            'email' => $email,
            'password' => $_POST['password'],
            'nombres' => $_POST['nombres'] ?? '',
            'apellido_paterno' => $_POST['apellido_paterno'] ?? '',
            'apellido_materno' => $_POST['apellido_materno'] ?? '',
            'estado_reniec' => $_POST['estado_reniec'] ?? null,
            'condicion_reniec' => $_POST['condicion_reniec'] ?? null,
            'direccion' => $_POST['direccion'] ?? null,
            'ubigeo' => $_POST['ubigeo'] ?? null,
            'departamento' => $_POST['departamento'] ?? null,
            'provincia' => $_POST['provincia'] ?? null,
            'distrito' => $_POST['distrito'] ?? null,
            'activo' => 1
        ];

        $usuarioId = $usuarioModel->createUsuario($data);

        if ($usuarioId) {
            // Iniciar sesión automáticamente
            $usuario = $usuarioModel->find($usuarioId);
            $_SESSION['postulante_id'] = $usuario['id'];
            $_SESSION['postulante_dni'] = $usuario['dni'];
            $_SESSION['postulante_email'] = $usuario['email'];
            $_SESSION['postulante_nombres'] = $usuario['nombres'];
            $_SESSION['postulante_apellido_paterno'] = $usuario['apellido_paterno'];
            $_SESSION['postulante_apellido_materno'] = $usuario['apellido_materno'];
            $_SESSION['postulante_nombre_completo'] = trim($usuario['nombres'] . ' ' . $usuario['apellido_paterno'] . ' ' . $usuario['apellido_materno']);

            $_SESSION['success'] = '¡Registro exitoso! Ya puedes postularte a nuestras convocatorias.';
            $this->redirect('/');
        } else {
            $_SESSION['error'] = 'Error al crear la cuenta. Por favor intenta nuevamente.';
            $this->redirect('/postulante/registro');
        }
    }

    /**
     * Mostrar formulario de login
     */
    public function login() {
        // Si ya está logueado, redirigir a inicio
        if (isset($_SESSION['postulante_id'])) {
            $this->redirect('/');
        }

        $this->view('public/login');
    }

    /**
     * Procesar login de postulante
     */
    public function loginPost() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/postulante/login');
        }

        $usuarioModel = new UsuarioPostulante();
        $dni = $_POST['dni'] ?? '';
        $password = $_POST['password'] ?? '';

        // Validar credenciales
        $usuario = $usuarioModel->validateLogin($dni, $password);

        if ($usuario) {
            // Actualizar último login
            $usuarioModel->updateLastLogin($usuario['id']);

            // Iniciar sesión
            $_SESSION['postulante_id'] = $usuario['id'];
            $_SESSION['postulante_dni'] = $usuario['dni'];
            $_SESSION['postulante_email'] = $usuario['email'];
            $_SESSION['postulante_nombres'] = $usuario['nombres'];
            $_SESSION['postulante_apellido_paterno'] = $usuario['apellido_paterno'];
            $_SESSION['postulante_apellido_materno'] = $usuario['apellido_materno'];
            $_SESSION['postulante_nombre_completo'] = trim($usuario['nombres'] . ' ' . $usuario['apellido_paterno'] . ' ' . $usuario['apellido_materno']);

            $_SESSION['success'] = '¡Bienvenido/a ' . $usuario['nombres'] . '!';

            // Redirigir a donde venía o a inicio
            $returnUrl = $_SESSION['return_url'] ?? '/';
            unset($_SESSION['return_url']);
            $this->redirect($returnUrl);
        } else {
            $_SESSION['error'] = 'DNI o contraseña incorrectos';
            $this->redirect('/postulante/login');
        }
    }

    /**
     * Cerrar sesión de postulante
     */
    public function logout() {
        // Limpiar variables de sesión de postulante
        unset($_SESSION['postulante_id']);
        unset($_SESSION['postulante_dni']);
        unset($_SESSION['postulante_email']);
        unset($_SESSION['postulante_nombres']);
        unset($_SESSION['postulante_apellido_paterno']);
        unset($_SESSION['postulante_apellido_materno']);
        unset($_SESSION['postulante_nombre_completo']);

        $_SESSION['success'] = 'Has cerrado sesión exitosamente';
        $this->redirect('/');
    }
}
