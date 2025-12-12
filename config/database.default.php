<?php
/**
 * Configuración de la base de datos - SIN PUERTO ESPECÍFICO
 *
 * Esta versión intenta conectar sin especificar puerto (usa el predeterminado)
 * Renombra este archivo a database.php si las otras versiones no funcionan
 */

define('DB_HOST', 'localhost');
// define('DB_PORT', '3306'); // Comentado - usa puerto predeterminado
define('DB_NAME', 'seleccion_personal');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

return [
    'host' => DB_HOST,
    // 'port' => DB_PORT, // Comentado - usa puerto predeterminado
    'database' => DB_NAME,
    'username' => DB_USER,
    'password' => DB_PASS,
    'charset' => DB_CHARSET
];
