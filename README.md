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

### 2. Configurar la base de datos

Editar el archivo `config/database.php` con tus credenciales:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'seleccion_personal');
define('DB_USER', 'tu_usuario');
define('DB_PASS', 'tu_contraseña');
```

### 3. Importar la base de datos

```bash
mysql -u root -p < database.sql
```

O desde phpMyAdmin:
1. Crear base de datos `seleccion_personal`
2. Importar el archivo `database.sql`

### 4. Configurar permisos

```bash
chmod 755 public/uploads
```

### 5. Configurar la URL base

Editar `config/app.php`:

```php
define('APP_URL', 'http://localhost/seleccion');
```

### 6. Configurar Apache

Si usas Apache, asegúrate de que el archivo `.htaccess` esté presente y mod_rewrite esté habilitado.

Para habilitar mod_rewrite:
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
