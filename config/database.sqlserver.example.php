<?php
/**
 * Configuración de la base de datos - SQL SERVER (EJEMPLO)
 *
 * Instrucciones de instalación del driver:
 *
 * WINDOWS (XAMPP/WAMP):
 * 1. Descarga Microsoft Drivers for PHP for SQL Server:
 *    https://docs.microsoft.com/en-us/sql/connect/php/download-drivers-php-sql-server
 * 2. Extrae los archivos y copia los .dll apropiados según tu versión de PHP:
 *    - php_pdo_sqlsrv_XX_ts.dll (para thread-safe)
 *    - php_sqlsrv_XX_ts.dll
 *    Donde XX es tu versión de PHP (74, 80, 81, etc.)
 * 3. Copia los archivos a C:\xampp\php\ext\
 * 4. Edita php.ini (C:\xampp\php\php.ini) y agrega:
 *    extension=php_pdo_sqlsrv_XX_ts.dll
 *    extension=php_sqlsrv_XX_ts.dll
 * 5. Reinicia Apache
 *
 * LINUX:
 * 1. Instala el driver:
 *    sudo pecl install sqlsrv pdo_sqlsrv
 * 2. Agrega a php.ini:
 *    extension=sqlsrv.so
 *    extension=pdo_sqlsrv.so
 * 3. Reinicia el servidor web
 *
 * VERIFICACIÓN:
 * Ejecuta: php -m | grep sqlsrv
 * Deberías ver: pdo_sqlsrv y sqlsrv
 */

define('DB_DRIVER', 'sqlsrv');
define('DB_HOST', 'localhost'); // o dirección IP del servidor SQL Server
define('DB_PORT', '1433'); // Puerto estándar de SQL Server
define('DB_NAME', 'seleccion_personal');
define('DB_USER', 'sa'); // Usuario administrador de SQL Server
define('DB_PASS', 'TuContraseñaSegura123!'); // Contraseña del usuario
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
