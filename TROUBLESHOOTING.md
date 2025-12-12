# Solución de Problemas Comunes

## Error: "Failed to open stream: No such file or directory in Database.php"

### Causa
El archivo `config/database.php` no existe o no se encuentra correctamente.

### Solución

**Paso 1:** Copia el archivo de configuración de ejemplo

```bash
# En Windows (CMD):
cd C:\xampp\htdocs\seleccion
copy config\database.example.php config\database.php

# En PowerShell:
Copy-Item config\database.example.php config\database.php

# En Linux/Mac:
cp config/database.example.php config/database.php
```

**Paso 2:** Edita `config/database.php` con tus credenciales

Abre el archivo `config/database.php` y configura:

```php
define('DB_HOST', 'localhost');
define('DB_PORT', '3307'); // Cambia a 3306 si tu MySQL usa el puerto estándar
define('DB_NAME', 'seleccion_personal');
define('DB_USER', 'root');
define('DB_PASS', ''); // Coloca tu contraseña si tienes una
```

**Paso 3:** Verifica que la base de datos existe

1. Abre phpMyAdmin: `http://localhost/phpmyadmin`
2. Verifica que existe la base de datos `seleccion_personal`
3. Si no existe, créala o importa el archivo `database.sql`

---

## Error: "SQLSTATE[HY000] [2002] Connection refused"

### Causa
MySQL no está corriendo o el puerto es incorrecto.

### Solución

**Para XAMPP:**
1. Abre el Panel de Control de XAMPP
2. Verifica que MySQL esté corriendo (botón verde "Running")
3. Si no está corriendo, haz clic en "Start"

**Verificar el puerto correcto:**
1. Abre `C:\xampp\phpMyAdmin\config.inc.php`
2. Busca la línea: `$cfg['Servers'][$i]['port'] = '3307';`
3. Usa ese mismo puerto en `config/database.php`

---

## Error: "SQLSTATE[HY000] [1045] Access denied for user 'root'@'localhost'"

### Causa
Las credenciales de MySQL son incorrectas.

### Solución

**En XAMPP (Windows):**
- Usuario por defecto: `root`
- Contraseña por defecto: `` (vacía, sin contraseña)

Edita `config/database.php`:
```php
define('DB_USER', 'root');
define('DB_PASS', ''); // Vacía para XAMPP
```

**Si has cambiado la contraseña:**
- Usa la contraseña que configuraste en MySQL

---

## Error: "Warning: require(BASE_PATH): Failed to open stream"

### Causa
La constante `BASE_PATH` no está definida.

### Solución

Verifica que estás accediendo al sistema a través del archivo `index.php`:
- Correcto: `http://localhost/seleccion/`
- Incorrecto: `http://localhost/seleccion/views/admin/login.php`

El sistema usa un router, todas las peticiones deben pasar por `index.php`.

---

## Error 404 - Página no encontrada

### Causa
El archivo `.htaccess` no está funcionando o mod_rewrite no está habilitado.

### Solución XAMPP

El `.htaccess` debería funcionar por defecto en XAMPP. Verifica:

1. El archivo `.htaccess` existe en la raíz del proyecto
2. El contenido del archivo es correcto

**Alternativa:** Accede usando rutas completas:
- Login: `http://localhost/seleccion/index.php/login`
- Home: `http://localhost/seleccion/index.php/`

### Solución Apache (Linux)

```bash
sudo a2enmod rewrite
sudo service apache2 restart
```

Edita `/etc/apache2/apache2.conf` o `/etc/apache2/sites-available/000-default.conf`:

```apache
<Directory /var/www/html>
    AllowOverride All
</Directory>
```

---

## No se pueden subir archivos CV

### Causa
Permisos de escritura incorrectos en la carpeta `public/uploads`.

### Solución Windows (XAMPP)

Los permisos deberían funcionar automáticamente. Si no:
1. Clic derecho en `C:\xampp\htdocs\seleccion\public\uploads`
2. Propiedades → Seguridad
3. Asegúrate de que "Usuarios" tenga permisos de "Escritura"

### Solución Linux/Mac

```bash
chmod -R 755 public/uploads
chown -R www-data:www-data public/uploads  # Usuario del servidor web
```

---

## Error: "Maximum upload file size exceeded"

### Causa
El archivo CV excede el límite de carga de PHP.

### Solución

Edita `php.ini` (en XAMPP: `C:\xampp\php\php.ini`):

```ini
upload_max_filesize = 10M
post_max_size = 12M
```

Reinicia Apache después de hacer el cambio.

---

## Verificación rápida de configuración

Crea un archivo `test.php` en la raíz del proyecto:

```php
<?php
echo "<h1>Test de Configuración</h1>";

echo "<h2>PHP Info</h2>";
echo "Versión PHP: " . phpversion() . "<br>";

echo "<h2>Extensiones</h2>";
echo "PDO: " . (extension_loaded('pdo') ? 'OK' : 'NO INSTALADO') . "<br>";
echo "PDO MySQL: " . (extension_loaded('pdo_mysql') ? 'OK' : 'NO INSTALADO') . "<br>";

echo "<h2>Archivos</h2>";
echo "BASE_PATH definido: " . (defined('BASE_PATH') ? 'SI' : 'NO') . "<br>";

if (file_exists(__DIR__ . '/config/database.php')) {
    echo "config/database.php: EXISTE<br>";
    require __DIR__ . '/config/app.php';
    $config = require __DIR__ . '/config/database.php';
    echo "Puerto MySQL configurado: " . ($config['port'] ?? 'No definido') . "<br>";
} else {
    echo "config/database.php: <strong>NO EXISTE</strong><br>";
}

echo "<h2>Conexión MySQL</h2>";
try {
    require __DIR__ . '/config/app.php';
    require __DIR__ . '/core/Database.php';
    $db = Database::getInstance();
    echo "Conexión: <strong>EXITOSA</strong>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
```

Accede a: `http://localhost/seleccion/test.php`

**IMPORTANTE:** Elimina este archivo después de hacer las pruebas.

---

## ¿Necesitas más ayuda?

Si ninguna de estas soluciones funciona, verifica:

1. ✅ Apache y MySQL están corriendo
2. ✅ El archivo `config/database.php` existe y tiene las credenciales correctas
3. ✅ La base de datos `seleccion_personal` existe e importaste `database.sql`
4. ✅ Estás accediendo a través de `http://localhost/seleccion/`
5. ✅ No hay errores en los logs de Apache (`C:\xampp\apache\logs\error.log`)
