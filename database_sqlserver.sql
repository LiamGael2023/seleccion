-- =============================================
-- Base de datos para Sistema de Selección de Personal
-- SQL SERVER VERSION
-- =============================================
-- Este script crea la estructura de base de datos para SQL Server
-- Conversión de MySQL a SQL Server con todas las funcionalidades

-- Crear la base de datos si no existe
IF NOT EXISTS (SELECT name FROM sys.databases WHERE name = 'seleccion_personal')
BEGIN
    CREATE DATABASE seleccion_personal;
END
GO

USE seleccion_personal;
GO

-- =============================================
-- Tabla de usuarios administradores
-- =============================================
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[usuarios]') AND type in (N'U'))
BEGIN
    CREATE TABLE usuarios (
        id INT IDENTITY(1,1) PRIMARY KEY,
        nombre NVARCHAR(100) NOT NULL,
        email NVARCHAR(100) NOT NULL UNIQUE,
        password NVARCHAR(255) NOT NULL,
        rol NVARCHAR(10) NOT NULL DEFAULT 'rrhh' CHECK (rol IN ('admin', 'rrhh')),
        activo BIT NOT NULL DEFAULT 1,
        created_at DATETIME2 NOT NULL DEFAULT GETDATE(),
        updated_at DATETIME2 NOT NULL DEFAULT GETDATE()
    );
END
GO

-- Trigger para actualizar updated_at automáticamente en usuarios
IF EXISTS (SELECT * FROM sys.triggers WHERE name = 'trg_usuarios_update')
    DROP TRIGGER trg_usuarios_update;
GO

CREATE TRIGGER trg_usuarios_update
ON usuarios
AFTER UPDATE
AS
BEGIN
    SET NOCOUNT ON;
    UPDATE usuarios
    SET updated_at = GETDATE()
    FROM usuarios u
    INNER JOIN inserted i ON u.id = i.id;
END
GO

-- =============================================
-- Tabla de áreas/departamentos
-- =============================================
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[areas]') AND type in (N'U'))
BEGIN
    CREATE TABLE areas (
        id INT IDENTITY(1,1) PRIMARY KEY,
        nombre NVARCHAR(100) NOT NULL,
        descripcion NVARCHAR(MAX),
        activo BIT NOT NULL DEFAULT 1,
        created_at DATETIME2 NOT NULL DEFAULT GETDATE(),
        updated_at DATETIME2 NOT NULL DEFAULT GETDATE()
    );
END
GO

-- Trigger para actualizar updated_at en areas
IF EXISTS (SELECT * FROM sys.triggers WHERE name = 'trg_areas_update')
    DROP TRIGGER trg_areas_update;
GO

CREATE TRIGGER trg_areas_update
ON areas
AFTER UPDATE
AS
BEGIN
    SET NOCOUNT ON;
    UPDATE areas
    SET updated_at = GETDATE()
    FROM areas a
    INNER JOIN inserted i ON a.id = i.id;
END
GO

-- =============================================
-- Tabla de carreras universitarias
-- =============================================
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[carreras]') AND type in (N'U'))
BEGIN
    CREATE TABLE carreras (
        id INT IDENTITY(1,1) PRIMARY KEY,
        nombre NVARCHAR(150) NOT NULL,
        nivel NVARCHAR(20) NOT NULL DEFAULT 'licenciatura' CHECK (nivel IN ('tecnico', 'licenciatura', 'ingenieria', 'maestria', 'doctorado')),
        activo BIT NOT NULL DEFAULT 1,
        created_at DATETIME2 NOT NULL DEFAULT GETDATE(),
        updated_at DATETIME2 NOT NULL DEFAULT GETDATE()
    );
END
GO

-- Trigger para actualizar updated_at en carreras
IF EXISTS (SELECT * FROM sys.triggers WHERE name = 'trg_carreras_update')
    DROP TRIGGER trg_carreras_update;
GO

CREATE TRIGGER trg_carreras_update
ON carreras
AFTER UPDATE
AS
BEGIN
    SET NOCOUNT ON;
    UPDATE carreras
    SET updated_at = GETDATE()
    FROM carreras c
    INNER JOIN inserted i ON c.id = i.id;
END
GO

-- =============================================
-- Tabla de convocatorias (contenedor general)
-- =============================================
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[convocatorias]') AND type in (N'U'))
BEGIN
    CREATE TABLE convocatorias (
        id INT IDENTITY(1,1) PRIMARY KEY,
        titulo NVARCHAR(200) NOT NULL, -- Ej: Prácticas Profesionales Periodo 1
        descripcion NVARCHAR(MAX), -- Descripción general de la convocatoria
        tipo_contrato NVARCHAR(20) NOT NULL DEFAULT 'practicas' CHECK (tipo_contrato IN ('tiempo_completo', 'medio_tiempo', 'temporal', 'practicas')),
        salario_min DECIMAL(10,2),
        salario_max DECIMAL(10,2),
        fecha_inicio DATE NOT NULL,
        fecha_cierre DATE NOT NULL,
        estado NVARCHAR(20) NOT NULL DEFAULT 'borrador' CHECK (estado IN ('borrador', 'publicada', 'cerrada', 'cancelada')),
        usuario_id INT NOT NULL,
        created_at DATETIME2 NOT NULL DEFAULT GETDATE(),
        updated_at DATETIME2 NOT NULL DEFAULT GETDATE(),
        CONSTRAINT FK_convocatorias_usuarios FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
    );
END
GO

-- Índice para mejorar búsquedas por usuario
CREATE NONCLUSTERED INDEX IX_convocatorias_usuario
ON convocatorias(usuario_id);
GO

-- Trigger para actualizar updated_at en convocatorias
IF EXISTS (SELECT * FROM sys.triggers WHERE name = 'trg_convocatorias_update')
    DROP TRIGGER trg_convocatorias_update;
GO

CREATE TRIGGER trg_convocatorias_update
ON convocatorias
AFTER UPDATE
AS
BEGIN
    SET NOCOUNT ON;
    UPDATE convocatorias
    SET updated_at = GETDATE()
    FROM convocatorias c
    INNER JOIN inserted i ON c.id = i.id;
END
GO

-- =============================================
-- Tabla de perfiles dentro de una convocatoria
-- =============================================
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[perfiles_convocatoria]') AND type in (N'U'))
BEGIN
    CREATE TABLE perfiles_convocatoria (
        id INT IDENTITY(1,1) PRIMARY KEY,
        convocatoria_id INT NOT NULL,
        titulo NVARCHAR(200) NOT NULL, -- Ej: Practicante de Ingeniería Civil
        area_id INT NOT NULL, -- Ej: Operación y Mantenimiento
        descripcion NVARCHAR(MAX) NOT NULL,
        requisitos NVARCHAR(MAX) NOT NULL,
        responsabilidades NVARCHAR(MAX),
        experiencia_requerida INT NOT NULL DEFAULT 0, -- Años de experiencia
        vacantes INT NOT NULL DEFAULT 1,
        activo BIT NOT NULL DEFAULT 1,
        orden INT NOT NULL DEFAULT 0, -- Orden de visualización
        created_at DATETIME2 NOT NULL DEFAULT GETDATE(),
        updated_at DATETIME2 NOT NULL DEFAULT GETDATE(),
        CONSTRAINT FK_perfiles_convocatorias FOREIGN KEY (convocatoria_id) REFERENCES convocatorias(id) ON DELETE CASCADE,
        CONSTRAINT FK_perfiles_areas FOREIGN KEY (area_id) REFERENCES areas(id)
    );
END
GO

-- Índices para mejorar búsquedas
CREATE NONCLUSTERED INDEX IX_perfiles_convocatoria
ON perfiles_convocatoria(convocatoria_id);
GO

CREATE NONCLUSTERED INDEX IX_perfiles_area
ON perfiles_convocatoria(area_id);
GO

-- Trigger para actualizar updated_at en perfiles_convocatoria
IF EXISTS (SELECT * FROM sys.triggers WHERE name = 'trg_perfiles_convocatoria_update')
    DROP TRIGGER trg_perfiles_convocatoria_update;
GO

CREATE TRIGGER trg_perfiles_convocatoria_update
ON perfiles_convocatoria
AFTER UPDATE
AS
BEGIN
    SET NOCOUNT ON;
    UPDATE perfiles_convocatoria
    SET updated_at = GETDATE()
    FROM perfiles_convocatoria p
    INNER JOIN inserted i ON p.id = i.id;
END
GO

-- =============================================
-- Tabla de relación perfil-carrera (muchos a muchos)
-- =============================================
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[perfil_carreras]') AND type in (N'U'))
BEGIN
    CREATE TABLE perfil_carreras (
        id INT IDENTITY(1,1) PRIMARY KEY,
        perfil_id INT NOT NULL,
        carrera_id INT NOT NULL,
        created_at DATETIME2 NOT NULL DEFAULT GETDATE(),
        CONSTRAINT FK_perfil_carreras_perfiles FOREIGN KEY (perfil_id) REFERENCES perfiles_convocatoria(id) ON DELETE CASCADE,
        CONSTRAINT FK_perfil_carreras_carreras FOREIGN KEY (carrera_id) REFERENCES carreras(id) ON DELETE CASCADE,
        CONSTRAINT UQ_perfil_carrera UNIQUE (perfil_id, carrera_id)
    );
END
GO

-- =============================================
-- Tabla de candidatos
-- =============================================
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[candidatos]') AND type in (N'U'))
BEGIN
    CREATE TABLE candidatos (
        id INT IDENTITY(1,1) PRIMARY KEY,
        nombre NVARCHAR(100) NOT NULL,
        apellido_paterno NVARCHAR(100) NOT NULL,
        apellido_materno NVARCHAR(100),
        email NVARCHAR(100) NOT NULL,
        telefono NVARCHAR(20),
        fecha_nacimiento DATE,
        direccion NVARCHAR(MAX),
        ciudad NVARCHAR(100),
        estado NVARCHAR(100),
        codigo_postal NVARCHAR(10),
        carrera_id INT,
        nivel_estudios NVARCHAR(20) CHECK (nivel_estudios IN ('secundaria', 'preparatoria', 'tecnico', 'licenciatura', 'maestria', 'doctorado')),
        institucion NVARCHAR(200),
        anio_graduacion INT,
        experiencia_laboral NVARCHAR(MAX),
        habilidades NVARCHAR(MAX),
        cv_path NVARCHAR(255),
        created_at DATETIME2 NOT NULL DEFAULT GETDATE(),
        updated_at DATETIME2 NOT NULL DEFAULT GETDATE(),
        CONSTRAINT FK_candidatos_carreras FOREIGN KEY (carrera_id) REFERENCES carreras(id)
    );
END
GO

-- Trigger para actualizar updated_at en candidatos
IF EXISTS (SELECT * FROM sys.triggers WHERE name = 'trg_candidatos_update')
    DROP TRIGGER trg_candidatos_update;
GO

CREATE TRIGGER trg_candidatos_update
ON candidatos
AFTER UPDATE
AS
BEGIN
    SET NOCOUNT ON;
    UPDATE candidatos
    SET updated_at = GETDATE()
    FROM candidatos c
    INNER JOIN inserted i ON c.id = i.id;
END
GO

-- =============================================
-- Tabla de postulaciones (relacionadas con perfiles específicos)
-- =============================================
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[postulaciones]') AND type in (N'U'))
BEGIN
    CREATE TABLE postulaciones (
        id INT IDENTITY(1,1) PRIMARY KEY,
        convocatoria_id INT NOT NULL, -- Referencia a la convocatoria general
        perfil_id INT NOT NULL, -- Referencia al perfil específico
        candidato_id INT NOT NULL,
        estado NVARCHAR(20) NOT NULL DEFAULT 'pendiente' CHECK (estado IN ('pendiente', 'revision', 'entrevista', 'aceptado', 'rechazado')),
        puntuacion INT NOT NULL DEFAULT 0,
        comentarios NVARCHAR(MAX),
        fecha_postulacion DATETIME2 NOT NULL DEFAULT GETDATE(),
        fecha_actualizacion DATETIME2 NOT NULL DEFAULT GETDATE(),
        CONSTRAINT FK_postulaciones_convocatorias FOREIGN KEY (convocatoria_id) REFERENCES convocatorias(id) ON DELETE CASCADE,
        CONSTRAINT FK_postulaciones_perfiles FOREIGN KEY (perfil_id) REFERENCES perfiles_convocatoria(id),
        CONSTRAINT FK_postulaciones_candidatos FOREIGN KEY (candidato_id) REFERENCES candidatos(id),
        CONSTRAINT UQ_postulacion UNIQUE (perfil_id, candidato_id)
    );
END
GO

-- Índice para mejorar búsquedas por perfil
CREATE NONCLUSTERED INDEX IX_postulaciones_perfil
ON postulaciones(perfil_id);
GO

-- Trigger para actualizar fecha_actualizacion en postulaciones
IF EXISTS (SELECT * FROM sys.triggers WHERE name = 'trg_postulaciones_update')
    DROP TRIGGER trg_postulaciones_update;
GO

CREATE TRIGGER trg_postulaciones_update
ON postulaciones
AFTER UPDATE
AS
BEGIN
    SET NOCOUNT ON;
    UPDATE postulaciones
    SET fecha_actualizacion = GETDATE()
    FROM postulaciones p
    INNER JOIN inserted i ON p.id = i.id;
END
GO

-- =============================================
-- DATOS INICIALES
-- =============================================

-- Insertar usuario administrador por defecto
-- Password: admin123 (hasheado con password_hash de PHP)
IF NOT EXISTS (SELECT * FROM usuarios WHERE email = 'admin@seleccion.com')
BEGIN
    INSERT INTO usuarios (nombre, email, password, rol) VALUES
    ('Administrador', 'admin@seleccion.com', '$2y$12$i/fI3ro.fxOa7Ka41e2pAOy7NK5lUjLEZAjYp5iNP5PrO7Of5hlhu', 'admin');
END
GO

-- Insertar algunas áreas de ejemplo
IF NOT EXISTS (SELECT * FROM areas WHERE nombre = 'Recursos Humanos')
BEGIN
    INSERT INTO areas (nombre, descripcion) VALUES
    ('Recursos Humanos', 'Área de gestión del talento humano'),
    ('Tecnología', 'Área de desarrollo y sistemas'),
    ('Administración', 'Área administrativa y financiera'),
    ('Ventas', 'Área comercial y ventas'),
    ('Marketing', 'Área de marketing y comunicación'),
    ('Operación y Mantenimiento', 'Área de operaciones y mantenimiento'),
    ('Producción', 'Área de producción y manufactura'),
    ('Logística', 'Área de logística y almacenamiento');
END
GO

-- Insertar algunas carreras de ejemplo
IF NOT EXISTS (SELECT * FROM carreras WHERE nombre = 'Ingeniería en Sistemas')
BEGIN
    INSERT INTO carreras (nombre, nivel) VALUES
    ('Ingeniería en Sistemas', 'ingenieria'),
    ('Administración de Empresas', 'licenciatura'),
    ('Contaduría Pública', 'licenciatura'),
    ('Psicología', 'licenciatura'),
    ('Marketing', 'licenciatura'),
    ('Recursos Humanos', 'licenciatura'),
    ('Ingeniería Industrial', 'ingenieria'),
    ('Diseño Gráfico', 'licenciatura'),
    ('Comunicación', 'licenciatura'),
    ('Derecho', 'licenciatura'),
    ('Ingeniería Civil', 'ingenieria'),
    ('Ingeniería Agrícola', 'ingenieria'),
    ('Ingeniería Agronómica', 'ingenieria'),
    ('Ingeniería Mecánica', 'ingenieria'),
    ('Ingeniería Eléctrica', 'ingenieria');
END
GO

-- =============================================
-- DATOS DE EJEMPLO (opcional - comentar si no se necesitan)
-- =============================================

-- Ejemplo de convocatoria con múltiples perfiles
IF NOT EXISTS (SELECT * FROM convocatorias WHERE titulo = 'Prácticas Profesionales Periodo 1 - 2025')
BEGIN
    INSERT INTO convocatorias (titulo, descripcion, tipo_contrato, fecha_inicio, fecha_cierre, estado, usuario_id) VALUES
    ('Prácticas Profesionales Periodo 1 - 2025', 'Convocatoria para prácticas profesionales en diferentes áreas de la empresa', 'practicas', '2025-01-15', '2025-02-15', 'publicada', 1);

    -- Obtener el ID de la convocatoria recién creada
    DECLARE @convocatoria_id INT = SCOPE_IDENTITY();

    -- Perfiles de ejemplo para la convocatoria
    INSERT INTO perfiles_convocatoria (convocatoria_id, titulo, area_id, descripcion, requisitos, responsabilidades, experiencia_requerida, vacantes, orden) VALUES
    (@convocatoria_id, 'Practicante de Ingeniería Civil', 6, 'Apoyo en proyectos de infraestructura y mantenimiento', 'Estudiante activo de Ingeniería Civil o carreras afines. Conocimientos en AutoCAD y software de diseño.', 'Apoyar en la elaboración de planos, supervisión de obras, y control de proyectos.', 0, 1, 1),
    (@convocatoria_id, 'Practicante de Ingeniería Agrícola', 7, 'Apoyo en procesos de producción agrícola', 'Estudiante activo de Ingeniería Agrícola, Agronómica o carreras afines. Conocimientos en sistemas de riego.', 'Apoyar en el control de cultivos, sistemas de riego, y mejora de procesos productivos.', 0, 1, 2),
    (@convocatoria_id, 'Practicante de Ingeniería Industrial', 7, 'Apoyo en optimización de procesos productivos', 'Estudiante activo de Ingeniería Industrial o carreras afines. Conocimientos en herramientas de calidad.', 'Apoyar en análisis de procesos, control de calidad, y mejora continua.', 0, 2, 3);

    -- Asignar carreras a los perfiles
    -- Perfil 1: Ingeniería Civil (carrera_id = 11)
    INSERT INTO perfil_carreras (perfil_id, carrera_id)
    SELECT id, 11 FROM perfiles_convocatoria WHERE titulo = 'Practicante de Ingeniería Civil' AND convocatoria_id = @convocatoria_id;

    -- Perfil 2: Ingeniería Agrícola (12) y Agronómica (13)
    INSERT INTO perfil_carreras (perfil_id, carrera_id)
    SELECT id, 12 FROM perfiles_convocatoria WHERE titulo = 'Practicante de Ingeniería Agrícola' AND convocatoria_id = @convocatoria_id;

    INSERT INTO perfil_carreras (perfil_id, carrera_id)
    SELECT id, 13 FROM perfiles_convocatoria WHERE titulo = 'Practicante de Ingeniería Agrícola' AND convocatoria_id = @convocatoria_id;

    -- Perfil 3: Ingeniería Industrial (7)
    INSERT INTO perfil_carreras (perfil_id, carrera_id)
    SELECT id, 7 FROM perfiles_convocatoria WHERE titulo = 'Practicante de Ingeniería Industrial' AND convocatoria_id = @convocatoria_id;
END
GO

PRINT 'Base de datos creada exitosamente para SQL Server';
PRINT 'Usuario: admin@seleccion.com';
PRINT 'Password: admin123';
GO
