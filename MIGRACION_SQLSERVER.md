# Guía de Migración a SQL Server

Esta guía explica cómo migrar el Sistema de Selección de Personal de MySQL a Microsoft SQL Server.

## 📋 Tabla de Contenidos

1. [Requisitos Previos](#requisitos-previos)
2. [Instalación de Drivers PHP](#instalación-de-drivers-php)
3. [Configuración de SQL Server](#configuración-de-sql-server)
4. [Configuración de la Aplicación](#configuración-de-la-aplicación)
5. [Migración de Datos](#migración-de-datos)
6. [Diferencias Importantes](#diferencias-importantes)
7. [Solución de Problemas](#solución-de-problemas)

---

## 🔧 Requisitos Previos

### Software Necesario

- **SQL Server 2016 o superior** (Express, Standard, Enterprise, o Developer Edition)
- **PHP 7.4 o superior**
- **Microsoft Drivers for PHP for SQL Server**
- Servidor web (Apache, Nginx, IIS)

### Verificar Versión de PHP

```bash
php -v
```

---

## 📦 Instalación de Drivers PHP

### Windows (XAMPP/WAMP)

#### 1. Descargar Drivers

Descarga los drivers desde:
https://docs.microsoft.com/en-us/sql/connect/php/download-drivers-php-sql-server

O mediante PowerShell:
```powershell
# Ejemplo para PHP 8.1
Invoke-WebRequest -Uri "https://go.microsoft.com/fwlink/?linkid=2230791" -OutFile "SQLSRV.zip"
```

#### 2. Extraer e Instalar

```cmd
# Extrae el archivo ZIP descargado
# Busca los archivos correspondientes a tu versión de PHP

# Para PHP 8.1 Thread-Safe (TS):
# - php_pdo_sqlsrv_81_ts.dll
# - php_sqlsrv_81_ts.dll

# Copia estos archivos a:
C:\xampp\php\ext\
```

#### 3. Configurar php.ini

Edita `C:\xampp\php\php.ini` y agrega:

```ini
extension=php_pdo_sqlsrv_81_ts.dll
extension=php_sqlsrv_81_ts.dll
```

**Nota:** Ajusta el número de versión (81) según tu versión de PHP.

#### 4. Reiniciar Apache

```cmd
# Detener Apache
C:\xampp\apache\bin\httpd.exe -k stop

# Iniciar Apache
C:\xampp\apache\bin\httpd.exe -k start
```

### Linux (Ubuntu/Debian)

#### 1. Instalar Dependencias

```bash
sudo apt-get update
sudo apt-get install -y php-dev php-pear unixodbc-dev
```

#### 2. Instalar Microsoft ODBC Driver

```bash
# Agregar repositorio de Microsoft
curl https://packages.microsoft.com/keys/microsoft.asc | sudo apt-key add -
curl https://packages.microsoft.com/config/ubuntu/$(lsb_release -rs)/prod.list | sudo tee /etc/apt/sources.list.d/mssql-release.list

# Instalar driver
sudo apt-get update
sudo ACCEPT_EULA=Y apt-get install -y msodbcsql17
```

#### 3. Instalar Extensiones PHP

```bash
sudo pecl install sqlsrv
sudo pecl install pdo_sqlsrv
```

#### 4. Habilitar Extensiones

```bash
# Agregar a php.ini
echo "extension=sqlsrv.so" | sudo tee -a /etc/php/8.1/apache2/php.ini
echo "extension=pdo_sqlsrv.so" | sudo tee -a /etc/php/8.1/apache2/php.ini

# Reiniciar Apache
sudo systemctl restart apache2
```

### Verificar Instalación

```bash
php -m | grep sqlsrv
```

Deberías ver:
```
pdo_sqlsrv
sqlsrv
```

---

## 🗄️ Configuración de SQL Server

### 1. Crear la Base de Datos

Ejecuta el script SQL proporcionado:

```sql
-- Usando SQL Server Management Studio (SSMS)
-- O mediante línea de comandos:

sqlcmd -S localhost -U sa -P TuContraseña -i database_sqlserver.sql
```

### 2. Habilitar Autenticación Mixta

Si usas autenticación SQL Server (recomendado para desarrollo):

1. Abrir SQL Server Configuration Manager
2. Habilitar autenticación de SQL Server
3. Reiniciar el servicio de SQL Server

### 3. Configurar Firewall (si es necesario)

```powershell
# Windows Firewall
netsh advfirewall firewall add rule name="SQL Server" dir=in action=allow protocol=TCP localport=1433
```

### 4. Verificar Puerto

SQL Server usa el puerto **1433** por defecto. Verifica que esté escuchando:

```cmd
netstat -an | findstr 1433
```

---

## ⚙️ Configuración de la Aplicación

### 1. Copiar Archivo de Configuración

```bash
# En el directorio del proyecto
cp config/database.sqlserver.example.php config/database.php
```

### 2. Editar Configuración

Edita `config/database.php`:

```php
<?php
define('DB_DRIVER', 'sqlsrv');
define('DB_HOST', 'localhost'); // o IP del servidor
define('DB_PORT', '1433');
define('DB_NAME', 'seleccion_personal');
define('DB_USER', 'sa'); // tu usuario de SQL Server
define('DB_PASS', 'TuContraseñaSegura123!');
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
```

### 3. Actualizar Archivo de Entrada

Edita `index.php` para usar la clase DatabaseSQLServer:

```php
// Cambiar esta línea:
require_once BASE_PATH . '/core/Database.php';

// Por esta:
require_once BASE_PATH . '/core/DatabaseSQLServer.php';

// Y cambiar todas las referencias de Database por DatabaseSQLServer
// O renombrar la clase DatabaseSQLServer a Database
```

**Alternativa:** Renombrar la clase en el archivo para mantener compatibilidad:

```bash
# Respaldar archivo original
cp core/Database.php core/Database.mysql.php

# Copiar nueva versión
cp core/DatabaseSQLServer.php core/Database.php
```

---

## 📊 Migración de Datos

### Opción 1: Exportar/Importar Datos

Si ya tienes datos en MySQL y quieres migrarlos:

#### 1. Exportar desde MySQL

```bash
# Exportar solo datos (sin estructura)
mysqldump -u root -p seleccion_personal \
  --no-create-info \
  --complete-insert \
  --skip-extended-insert \
  > datos_mysql.sql
```

#### 2. Convertir y Adaptar

Los datos exportados necesitarán ajustes:

- Convertir comillas simples a sintaxis de SQL Server
- Ajustar formato de fechas
- Convertir valores booleanos (0/1 a BIT)

#### 3. Importar a SQL Server

```bash
sqlcmd -S localhost -U sa -P TuContraseña -d seleccion_personal -i datos_convertidos.sql
```

### Opción 2: Usar Herramientas de Microsoft

**SQL Server Migration Assistant (SSMA):**

1. Descargar SSMA for MySQL
2. Conectar a MySQL y SQL Server
3. Seleccionar base de datos origen
4. Ejecutar migración automática

---

## ⚠️ Diferencias Importantes

### Tipos de Datos

| MySQL | SQL Server | Notas |
|-------|------------|-------|
| `AUTO_INCREMENT` | `IDENTITY(1,1)` | Auto-incremento |
| `TINYINT(1)` | `BIT` | Booleano |
| `TEXT` | `NVARCHAR(MAX)` | Texto largo |
| `VARCHAR` | `NVARCHAR` | Unicode |
| `TIMESTAMP` | `DATETIME2` | Fecha y hora |
| `YEAR` | `INT` | Año |
| `ENUM` | `NVARCHAR + CHECK` | Valores limitados |

### Sintaxis SQL

| Característica | MySQL | SQL Server |
|----------------|-------|------------|
| Obtener último ID | `LAST_INSERT_ID()` | `SCOPE_IDENTITY()` |
| Fecha actual | `NOW()` | `GETDATE()` |
| Concatenación | `CONCAT()` | `CONCAT()` o `+` |
| Límite de registros | `LIMIT 10` | `TOP 10` o `OFFSET-FETCH` |
| Auto-actualización | `ON UPDATE CURRENT_TIMESTAMP` | Trigger |

### Funciones PHP

La clase `DatabaseSQLServer` proporciona método especial:

```php
// En lugar de:
$id = $db->lastInsertId();

// Usa el método de la clase:
$id = $db->lastInsertId();
// (Ya maneja la diferencia internamente)
```

---

## 🔍 Solución de Problemas

### Error: "could not find driver"

**Solución:**
```bash
# Verificar que el driver está instalado
php -m | grep sqlsrv

# Si no aparece, revisar la instalación del driver
```

### Error: "Login failed for user"

**Solución:**
1. Verificar credenciales en `config/database.php`
2. Asegurar que la autenticación SQL está habilitada
3. Verificar que el usuario tiene permisos

```sql
-- Crear nuevo usuario si es necesario
CREATE LOGIN tu_usuario WITH PASSWORD = 'TuContraseña123!';
USE seleccion_personal;
CREATE USER tu_usuario FOR LOGIN tu_usuario;
ALTER ROLE db_owner ADD MEMBER tu_usuario;
```

### Error: "Cannot open database"

**Solución:**
```sql
-- Verificar que la base de datos existe
SELECT name FROM sys.databases WHERE name = 'seleccion_personal';

-- Si no existe, ejecutar el script de creación
```

### Error de Conexión al Puerto

**Solución:**
```bash
# Verificar que SQL Server está escuchando en 1433
netstat -an | findstr 1433

# Habilitar TCP/IP en SQL Server Configuration Manager
# Reiniciar servicio de SQL Server
```

### Problemas de Encoding

**Solución:**
```php
// Asegurar UTF-8 en la configuración
'options' => [
    PDO::SQLSRV_ATTR_ENCODING => PDO::SQLSRV_ENCODING_UTF8
]
```

---

## 📝 Notas Adicionales

### Rendimiento

- SQL Server usa índices automáticamente en claves primarias y únicas
- Los triggers para `updated_at` tienen un overhead mínimo
- Considera agregar índices adicionales según patrones de uso

### Backups

```sql
-- Backup completo
BACKUP DATABASE seleccion_personal
TO DISK = 'C:\Backups\seleccion_personal.bak'
WITH FORMAT, INIT, NAME = 'Full Backup';

-- Restaurar
RESTORE DATABASE seleccion_personal
FROM DISK = 'C:\Backups\seleccion_personal.bak'
WITH REPLACE;
```

### Seguridad

1. **Nunca** uses el usuario `sa` en producción
2. Crea usuarios específicos con permisos limitados
3. Usa contraseñas fuertes
4. Habilita SSL/TLS para conexiones remotas

---

## 📞 Soporte

### Recursos Útiles

- [Documentación oficial de SQL Server](https://docs.microsoft.com/sql/)
- [PHP SQL Server Drivers](https://docs.microsoft.com/sql/connect/php/)
- [SSMA for MySQL](https://docs.microsoft.com/sql/ssma/mysql/sql-server-migration-assistant-for-mysql-mysqltosql)

### Contacto

Si encuentras problemas, revisa los logs:

```bash
# PHP error log
tail -f /var/log/apache2/error.log  # Linux
# o
C:\xampp\apache\logs\error.log      # Windows

# SQL Server error log
# En SSMS: Management > SQL Server Logs
```

---

## ✅ Checklist de Migración

- [ ] SQL Server instalado y funcionando
- [ ] Drivers PHP instalados (`php -m | grep sqlsrv`)
- [ ] Base de datos creada (`database_sqlserver.sql`)
- [ ] Archivo de configuración creado (`config/database.php`)
- [ ] Código actualizado para usar `DatabaseSQLServer`
- [ ] Conexión exitosa verificada
- [ ] Datos migrados (si aplica)
- [ ] Pruebas de funcionalidad completadas
- [ ] Backup configurado

---

**Fecha:** 2025-01-18
**Versión:** 1.0
**Sistema:** Sistema de Selección de Personal - SQL Server Edition
