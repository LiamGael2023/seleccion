<?php
/**
 * Configuración de la base de datos - Puerto 3306
 *
 * Si tienes problemas con el puerto 3307, prueba esta versión
 * Renombra este archivo a database.php
 */

define('DB_HOST', 'localhost');
define('DB_PORT', '3306'); // Puerto estándar de MySQL
define('DB_NAME', 'seleccion_personal');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

return [
    'host' => DB_HOST,
    'port' => DB_PORT,
    'database' => DB_NAME,
    'username' => DB_USER,
    'password' => DB_PASS,
    'charset' => DB_CHARSET
];
