# Sistema de Selección de Personal - Versión SQL Server

## 🎯 Descripción

Esta es la versión adaptada del Sistema de Selección de Personal para funcionar con **Microsoft SQL Server** en lugar de MySQL. Mantiene todas las funcionalidades del sistema original con compatibilidad total para SQL Server 2016+.

## 🆕 Novedades de Esta Versión

### ✨ Características SQL Server

- ✅ **Soporte completo para SQL Server 2016, 2017, 2019, 2022**
- ✅ **Triggers automáticos** para actualización de timestamps
- ✅ **Índices optimizados** para mejor rendimiento
- ✅ **Tipos de datos nativos** de SQL Server (NVARCHAR, DATETIME2, BIT)
- ✅ **Constraints y validaciones** a nivel de base de datos
- ✅ **Transacciones ACID** completas
- ✅ **Compatibilidad con diseño institucional peruano** (Tabler.io)

## 📁 Archivos Principales

### Archivos de SQL Server

| Archivo | Descripción |
|---------|-------------|
| `database_sqlserver.sql` | Script completo de creación de base de datos para SQL Server |
| `config/database.sqlserver.php` | Configuración de conexión a SQL Server |
| `config/database.sqlserver.example.php` | Ejemplo de configuración con instrucciones |
| `core/DatabaseSQLServer.php` | Clase de conexión compatible con MySQL y SQL Server |
| `MIGRACION_SQLSERVER.md` | Guía detallada de migración paso a paso |

### Archivos Originales (MySQL)

| Archivo | Descripción |
|---------|-------------|
| `database.sql` | Script MySQL original (versión 1) |
| `database_v2.sql` | Script MySQL con soporte para perfiles |
| `core/Database.php` | Clase de conexión MySQL original |

## 🚀 Inicio Rápido

### 1. Requisitos

- SQL Server 2016 o superior
- PHP 7.4+ con extensiones `pdo_sqlsrv` y `sqlsrv`
- Servidor web (Apache, Nginx, IIS)

### 2. Instalación Rápida

```bash
# 1. Clonar o descargar el proyecto
git clone https://github.com/usuario/seleccion.git
cd seleccion

# 2. Instalar drivers PHP para SQL Server (ver MIGRACION_SQLSERVER.md)

# 3. Crear base de datos en SQL Server
sqlcmd -S localhost -U sa -P TuContraseña -i database_sqlserver.sql

# 4. Configurar conexión
cp config/database.sqlserver.example.php config/database.php
# Editar config/database.php con tus credenciales

# 5. Usar la clase DatabaseSQLServer
cp core/DatabaseSQLServer.php core/Database.php
# O actualizar index.php para usar DatabaseSQLServer

# 6. Acceder al sistema
# http://localhost/seleccion
```

### 3. Credenciales Por Defecto

```
Usuario: admin@seleccion.com
Contraseña: admin123
```

**⚠️ Importante:** Cambia la contraseña en producción.

## 🔧 Configuración

### Configuración Básica SQL Server

```php
// config/database.php
define('DB_DRIVER', 'sqlsrv');
define('DB_HOST', 'localhost');
define('DB_PORT', '1433');
define('DB_NAME', 'seleccion_personal');
define('DB_USER', 'sa');
define('DB_PASS', 'TuContraseña123!');
```

### Configuración para SQL Server Express

```php
// Si usas SQL Server Express con instancia nombrada
define('DB_HOST', 'localhost\SQLEXPRESS');
// No especificar puerto en este caso
```

### Configuración para SQL Server Remoto

```php
define('DB_HOST', '192.168.1.100'); // IP del servidor
define('DB_PORT', '1433');
// Asegurar que el firewall permite conexiones al puerto 1433
```

## 📊 Estructura de Base de Datos

### Tablas Principales

1. **usuarios** - Administradores del sistema
2. **areas** - Departamentos/áreas de la empresa
3. **carreras** - Carreras universitarias
4. **convocatorias** - Convocatorias de empleo/prácticas
5. **perfiles_convocatoria** - Perfiles específicos por convocatoria
6. **perfil_carreras** - Relación muchos a muchos entre perfiles y carreras
7. **candidatos** - Información de candidatos
8. **postulaciones** - Postulaciones de candidatos a perfiles

### Diagrama de Relaciones

```
usuarios (1) -----> (N) convocatorias
areas (1) --------> (N) perfiles_convocatoria
convocatorias (1) -> (N) perfiles_convocatoria
perfiles (N) <-----> (N) carreras (a través de perfil_carreras)
perfiles (1) ------> (N) postulaciones
candidatos (1) ----> (N) postulaciones
```

## 🆚 Diferencias con la Versión MySQL

### Tipos de Datos

| MySQL | SQL Server | Uso |
|-------|------------|-----|
| `INT AUTO_INCREMENT` | `INT IDENTITY(1,1)` | IDs auto-incrementales |
| `TINYINT(1)` | `BIT` | Valores booleanos |
| `TEXT` | `NVARCHAR(MAX)` | Textos largos |
| `VARCHAR(N)` | `NVARCHAR(N)` | Textos con unicode |
| `TIMESTAMP` | `DATETIME2` | Fechas y horas |
| `YEAR` | `INT` | Almacenar años |
| `ENUM('a','b')` | `NVARCHAR(N) + CHECK` | Valores limitados |

### Características Especiales

**Actualización Automática de Timestamps:**

MySQL:
```sql
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
```

SQL Server (con trigger):
```sql
updated_at DATETIME2 NOT NULL DEFAULT GETDATE()
-- + Trigger trg_tabla_update
```

**Último ID Insertado:**

```php
// La clase DatabaseSQLServer maneja esto automáticamente
$db = DatabaseSQLServer::getInstance();
$id = $db->lastInsertId(); // Funciona en MySQL y SQL Server
```

### Rendimiento

- SQL Server crea automáticamente índices en PRIMARY KEY y UNIQUE
- Los triggers tienen overhead mínimo (~1-2ms por operación)
- Usa índices NONCLUSTERED para búsquedas frecuentes
- Connection pooling nativo mejora rendimiento

## 🎨 Diseño de la Interfaz

### Diseño Institucional Peruano

El sistema incluye un diseño inspirado en sitios gubernamentales peruanos:

- **Colores institucionales:** Rojo (#C1272D), Azul (#003876), Verde (#00A651)
- **Tipografía:** Roboto y Open Sans
- **Framework:** Bootstrap 5.3 (reemplaza Tabler.io)
- **Iconos:** Font Awesome 6
- **Estilo:** Formal, profesional, con elementos oficiales

### Personalización

Para cambiar el diseño, edita:
```
public/assets/css/custom.css
```

## 🔐 Seguridad

### Recomendaciones

1. **No uses el usuario `sa` en producción**

```sql
-- Crear usuario específico
CREATE LOGIN app_user WITH PASSWORD = 'Contraseña!Segura123';
USE seleccion_personal;
CREATE USER app_user FOR LOGIN app_user;
ALTER ROLE db_datareader ADD MEMBER app_user;
ALTER ROLE db_datawriter ADD MEMBER app_user;
```

2. **Habilita SSL/TLS** para conexiones remotas

```php
'options' => [
    PDO::SQLSRV_ATTR_ENCRYPT => true,
    PDO::SQLSRV_ATTR_TRUST_SERVER_CERTIFICATE => false
]
```

3. **Usa contraseñas fuertes**
4. **Mantén SQL Server actualizado**
5. **Configura backups automáticos**

## 📚 Documentación Adicional

- [Guía de Migración](MIGRACION_SQLSERVER.md) - Migración paso a paso desde MySQL
- [Documentación SQL Server](https://docs.microsoft.com/sql/)
- [PHP SQL Server Drivers](https://docs.microsoft.com/sql/connect/php/)

## 🛠️ Herramientas Recomendadas

### Desarrollo

- **SQL Server Management Studio (SSMS)** - IDE oficial
- **Azure Data Studio** - Multiplataforma, moderno
- **VS Code + SQL Server Extension** - Editor ligero

### Gestión

- **SQL Server Profiler** - Monitoreo de queries
- **Database Tuning Advisor** - Optimización
- **SQL Server Agent** - Tareas programadas

## 📦 Backups

### Backup Manual

```sql
-- Backup completo
BACKUP DATABASE seleccion_personal
TO DISK = 'C:\Backups\seleccion_personal_full.bak'
WITH INIT, FORMAT, NAME = 'Backup Completo';
```

### Backup Automático

```sql
-- Configurar en SQL Server Agent
-- Frecuencia recomendada: Diario
```

### Restauración

```sql
RESTORE DATABASE seleccion_personal
FROM DISK = 'C:\Backups\seleccion_personal_full.bak'
WITH REPLACE, RECOVERY;
```

## 🐛 Solución de Problemas Comunes

### "Could not find driver"

```bash
# Verificar drivers
php -m | grep sqlsrv

# Si no aparece, instalar drivers (ver MIGRACION_SQLSERVER.md)
```

### "Login failed"

```sql
-- Verificar autenticación SQL habilitada
-- Verificar permisos del usuario
-- Verificar contraseña
```

### "Cannot open database"

```sql
-- Verificar que la base existe
SELECT name FROM sys.databases WHERE name = 'seleccion_personal';
```

### Errores de Conexión

```bash
# Verificar que SQL Server está escuchando
netstat -an | findstr 1433

# Verificar firewall
# Verificar TCP/IP habilitado en SQL Server Configuration Manager
```

## 📈 Monitoreo

### Queries Lentas

```sql
-- Ver queries más lentas
SELECT TOP 10
    qs.execution_count,
    qs.total_elapsed_time / 1000000 as total_elapsed_time_sec,
    SUBSTRING(qt.TEXT, (qs.statement_start_offset/2)+1,
        ((CASE qs.statement_end_offset
            WHEN -1 THEN DATALENGTH(qt.TEXT)
            ELSE qs.statement_end_offset
        END - qs.statement_start_offset)/2)+1) AS statement_text
FROM sys.dm_exec_query_stats qs
CROSS APPLY sys.dm_exec_sql_text(qs.sql_handle) qt
ORDER BY qs.total_elapsed_time DESC;
```

### Espacio Usado

```sql
EXEC sp_spaceused 'seleccion_personal';
```

## 🤝 Contribuir

Si encuentras bugs o tienes sugerencias:

1. Abre un issue en GitHub
2. Describe el problema detalladamente
3. Incluye versión de SQL Server y PHP
4. Proporciona logs de error

## 📄 Licencia

[Especificar licencia del proyecto]

## 👥 Autores

- Sistema original: [Nombre del desarrollador]
- Adaptación SQL Server: [Tu nombre]

---

**Última actualización:** 2025-01-18
**Versión:** 1.0 SQL Server
**Compatible con:** SQL Server 2016, 2017, 2019, 2022
**PHP:** 7.4, 8.0, 8.1, 8.2
