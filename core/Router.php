<?php
/**
 * Enrutador de la aplicación
 */
class Router {
    private $routes = [];
    private $notFoundHandler;

    public function get($path, $handler) {
        $this->addRoute('GET', $path, $handler);
    }

    public function post($path, $handler) {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute($method, $path, $handler) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function notFound($handler) {
        $this->notFoundHandler = $handler;
    }

    public function dispatch() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = $_SERVER['REQUEST_URI'];

        // Remover query string
        $requestUri = strtok($requestUri, '?');

        // Remover base path si existe
        $basePath = parse_url(APP_URL, PHP_URL_PATH);
        if ($basePath && strpos($requestUri, $basePath) === 0) {
            $requestUri = substr($requestUri, strlen($basePath));
        }

        $requestUri = $requestUri ?: '/';

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod) {
                $pattern = $this->convertToRegex($route['path']);

                if (preg_match($pattern, $requestUri, $matches)) {
                    array_shift($matches);
                    return $this->callHandler($route['handler'], $matches);
                }
            }
        }

        // Ruta no encontrada
        if ($this->notFoundHandler) {
            return $this->callHandler($this->notFoundHandler);
        }

        http_response_code(404);
        echo "404 - Página no encontrada";
    }

    private function convertToRegex($path) {
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_-]+)', $path);
        return '#^' . $pattern . '$#';
    }

    private function callHandler($handler, $params = []) {
        if (is_callable($handler)) {
            return call_user_func_array($handler, $params);
        }

        if (is_string($handler)) {
            $parts = explode('@', $handler);
            if (count($parts) === 2) {
                [$controllerName, $method] = $parts;
                $controllerFile = BASE_PATH . "/controllers/{$controllerName}.php";

                if (file_exists($controllerFile)) {
                    require_once $controllerFile;
                    $controller = new $controllerName();

                    if (method_exists($controller, $method)) {
                        return call_user_func_array([$controller, $method], $params);
                    }
                }
            }
        }

        http_response_code(500);
        echo "Error: Handler no válido";
    }
}
