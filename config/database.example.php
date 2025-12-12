<?php
/**
 * Configuración de la base de datos - EJEMPLO
 *
 * Instrucciones:
 * 1. Copia este archivo como 'database.php' en la misma carpeta
 * 2. Actualiza los valores con tus credenciales de MySQL
 */

define('DB_HOST', 'localhost');
define('DB_PORT', '3306'); // Puerto de MySQL (3306 por defecto, 3307 para XAMPP con conflictos)
define('DB_NAME', 'seleccion_personal');
define('DB_USER', 'root');
define('DB_PASS', ''); // Tu contraseña de MySQL
define('DB_CHARSET', 'utf8mb4');

return [
    'host' => DB_HOST,
    'port' => DB_PORT,
    'database' => DB_NAME,
    'username' => DB_USER,
    'password' => DB_PASS,
    'charset' => DB_CHARSET
];
