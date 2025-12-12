<?php
require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/models/Usuario.php';

class AuthController extends Controller {

    public function login() {
        if ($this->isAuthenticated()) {
            $this->redirect('/admin/dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $usuarioModel = new Usuario();
            $user = $usuarioModel->authenticate($email, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nombre'];
                $_SESSION['user_role'] = $user['rol'];

                $this->redirect('/admin/dashboard');
            } else {
                $error = 'Credenciales incorrectas';
                $this->view('admin/login', compact('error'));
            }
        } else {
            $this->view('admin/login');
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('/login');
    }
}
