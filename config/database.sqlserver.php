<?php
/**
 * Configuración de la base de datos - SQL SERVER
 *
 * Instrucciones:
 * 1. Asegúrate de tener instalado el driver de SQL Server para PHP (sqlsrv o pdo_sqlsrv)
 * 2. Para instalar en Windows con XAMPP:
 *    - Descarga Microsoft Drivers for PHP for SQL Server
 *    - Copia los archivos .dll a la carpeta ext de PHP
 *    - Habilita la extensión en php.ini: extension=php_pdo_sqlsrv_XX_ts.dll
 * 3. Copia este archivo como 'database.php' en la misma carpeta
 * 4. Actualiza los valores con tus credenciales de SQL Server
 */

define('DB_DRIVER', 'sqlsrv'); // Driver: sqlsrv
define('DB_HOST', 'localhost'); // Servidor SQL Server
define('DB_PORT', '1433'); // Puerto de SQL Server (1433 por defecto)
define('DB_NAME', 'seleccion_personal');
define('DB_USER', 'sa'); // Usuario de SQL Server (sa por defecto)
define('DB_PASS', ''); // Tu contraseña de SQL Server
define('DB_CHARSET', 'UTF-8');

return [
    'driver' => DB_DRIVER,
    'host' => DB_HOST,
    'port' => DB_PORT,
    'database' => DB_NAME,
    'username' => DB_USER,
    'password' => DB_PASS,
    'charset' => DB_CHARSET,
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::SQLSRV_ATTR_ENCODING => PDO::SQLSRV_ENCODING_UTF8
    ]
];
