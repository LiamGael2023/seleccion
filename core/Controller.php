<?php
/**
 * Clase base para controladores
 */
class Controller {

    protected function view($view, $data = []) {
        extract($data);

        $viewPath = BASE_PATH . "/views/{$view}.php";

        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("Vista no encontrada: {$view}");
        }
    }

    protected function redirect($url) {
        header("Location: " . APP_URL . $url);
        exit;
    }

    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function isAuthenticated() {
        return isset($_SESSION['user_id']);
    }

    protected function requireAuth() {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
        }
    }

    protected function getCurrentUser() {
        if ($this->isAuthenticated()) {
            require_once BASE_PATH . '/models/Usuario.php';
            $usuarioModel = new Usuario();
            return $usuarioModel->find($_SESSION['user_id']);
        }
        return null;
    }
}
