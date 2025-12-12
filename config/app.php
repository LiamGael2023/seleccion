<?php
/**
 * Configuración general de la aplicación
 */

define('APP_NAME', 'Sistema de Selección de Personal');
define('APP_URL', 'http://localhost/seleccion');
define('BASE_PATH', __DIR__ . '/..');

// Zona horaria
date_default_timezone_set('America/Mexico_City');

// Mostrar errores en desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
