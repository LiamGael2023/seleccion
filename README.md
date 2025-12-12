# Sistema de Selección de Personal

Sistema completo de gestión de convocatorias laborales y postulaciones de candidatos, desarrollado con PHP MVC, MySQL y Tabler.io.

## Características

### Para Administradores
- **Gestión de Convocatorias**: Crear, editar y publicar convocatorias de trabajo
- **Gestión de Áreas**: Administrar departamentos y áreas de la empresa
- **Gestión de Carreras**: Administrar carreras universitarias aceptadas
- **Evaluación de Candidatos**: Revisar postulaciones, calificar y gestionar el proceso de selección
- **Dashboard**: Visualización de estadísticas y métricas

### Para Candidatos
- **Ver Convocatorias**: Explorar todas las convocatorias publicadas
- **Postularse en Línea**: Formulario completo para enviar postulación
- **Subir CV**: Adjuntar curriculum vitae en PDF o Word

## Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web Apache con mod_rewrite habilitado
- Extensiones PHP: PDO, pdo_mysql

## Instalación

### 1. Clonar o descargar el repositorio

```bash
git clone [url-del-repositorio]
cd seleccion
```

O descarga el ZIP y extráelo en `C:\xampp\htdocs\seleccion` (para XAMPP en Windows)

### 2. Configurar la base de datos

**IMPORTANTE:** Copia el archivo de configuración de ejemplo:

```bash
# En Windows (CMD o PowerShell):
copy config\database.example.php config\database.php

# En Linux/Mac:
cp config/database.example.php config/database.php
```

Luego edita `config/database.php` con tus credenciales:

```php
define('DB_HOST', 'localhost');
define('DB_PORT', '3307'); // 3307 para XAMPP, 3306 para MySQL estándar
define('DB_NAME', 'seleccion_personal');
define('DB_USER', 'root');
define('DB_PASS', ''); // Tu contraseña de MySQL (vacía por defecto en XAMPP)
```

**Nota para XAMPP:** Si MySQL usa el puerto 3307, asegúrate de configurarlo correctamente.

### 3. Importar la base de datos

**Opción A - Desde phpMyAdmin (Recomendado para XAMPP):**
1. Abre phpMyAdmin: `http://localhost/phpmyadmin` (o `http://localhost:8080/phpmyadmin`)
2. Crea una nueva base de datos llamada `seleccion_personal`
3. Selecciona la base de datos
4. Ve a la pestaña "Importar"
5. Selecciona el archivo `database.sql`
6. Haz clic en "Continuar"

**Opción B - Desde línea de comandos:**

```bash
# Windows (XAMPP):
C:\xampp\mysql\bin\mysql -u root -p --port=3307 < database.sql

# Linux/Mac:
mysql -u root -p < database.sql
```

### 4. Configurar permisos (Solo Linux/Mac)

```bash
chmod 755 public/uploads
```

**En Windows:** Los permisos se configuran automáticamente.

### 5. Configurar la URL base

Edita `config/app.php`:

```php
// Para XAMPP en Windows:
define('APP_URL', 'http://localhost/seleccion');

// Si usas otro puerto (ej: 8080):
define('APP_URL', 'http://localhost:8080/seleccion');
```

### 6. Iniciar el servidor

**XAMPP:**
1. Abre el Panel de Control de XAMPP
2. Inicia Apache
3. Inicia MySQL
4. Accede a: `http://localhost/seleccion`

**Apache (Linux/Mac):**

Asegúrate de que el archivo `.htaccess` esté presente y mod_rewrite esté habilitado.

```bash
sudo a2enmod rewrite
sudo service apache2 restart
```

## Acceso al Sistema

### Área de Administración
- URL: `http://localhost/seleccion/login`
- Usuario: `admin@seleccion.com`
- Contraseña: `admin123`

### Área Pública
- URL: `http://localhost/seleccion/`

## Estructura del Proyecto

```
seleccion/
├── config/              # Archivos de configuración
│   ├── app.php
│   └── database.php
├── controllers/         # Controladores MVC
│   ├── AuthController.php
│   ├── DashboardController.php
│   ├── ConvocatoriaController.php
│   ├── AreaController.php
│   ├── CarreraController.php
│   └── PublicController.php
├── core/               # Clases core del framework
│   ├── Controller.php
│   ├── Database.php
│   ├── Model.php
│   └── Router.php
├── models/             # Modelos de datos
│   ├── Usuario.php
│   ├── Area.php
│   ├── Carrera.php
│   ├── Convocatoria.php
│   ├── Candidato.php
│   └── Postulacion.php
├── views/              # Vistas
│   ├── layouts/
│   │   ├── admin.php
│   │   └── public.php
│   ├── admin/
│   │   ├── login.php
│   │   ├── dashboard.php
│   │   ├── convocatorias/
│   │   ├── areas/
│   │   └── carreras/
│   └── public/
│       ├── index.php
│       ├── detalle.php
│       └── aplicar.php
├── public/             # Archivos públicos
│   └── uploads/        # Archivos subidos
├── .htaccess          # Configuración Apache
├── index.php          # Punto de entrada
├── database.sql       # Script SQL
└── README.md
```

## Uso del Sistema

### Administradores

1. **Crear Áreas y Carreras**
   - Ir a "Áreas" y crear las áreas de tu empresa
   - Ir a "Carreras" y agregar las carreras universitarias

2. **Crear Convocatorias**
   - Ir a "Convocatorias" → "Nueva Convocatoria"
   - Completar el formulario con todos los detalles
   - Seleccionar las carreras aceptadas
   - Cambiar estado a "Publicada" para hacerla visible

3. **Gestionar Postulaciones**
   - Ir a "Convocatorias" → Ver postulaciones
   - Evaluar candidatos, asignar puntuaciones y cambiar estados
   - Estados disponibles: Pendiente, En Revisión, Entrevista, Aceptado, Rechazado

### Candidatos

1. **Explorar Convocatorias**
   - Visitar la página principal
   - Ver detalles de convocatorias de interés

2. **Postularse**
   - Hacer clic en "Postularme"
   - Completar el formulario con información personal, académica y profesional
   - Subir CV
   - Enviar postulación

## Tecnologías Utilizadas

- **Backend**: PHP 7.4+ con patrón MVC
- **Base de Datos**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript
- **Framework CSS**: Tabler.io
- **Iconos**: Tabler Icons

## Seguridad

- Contraseñas hasheadas con `password_hash()`
- Protección contra SQL Injection mediante PDO prepared statements
- Validación de archivos subidos
- Sesiones seguras para autenticación

## Licencia

Este proyecto es de código abierto y está disponible bajo la licencia MIT.

## Soporte

Para reportar bugs o solicitar características, por favor crear un issue en el repositorio.
