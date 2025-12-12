-- Base de datos para Sistema de Selección de Personal V2
-- Con soporte para múltiples perfiles por convocatoria

CREATE DATABASE IF NOT EXISTS seleccion_personal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE seleccion_personal;

-- Tabla de usuarios administradores
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'rrhh') DEFAULT 'rrhh',
    activo TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de áreas/departamentos
CREATE TABLE IF NOT EXISTS areas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    activo TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de carreras universitarias
CREATE TABLE IF NOT EXISTS carreras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    nivel ENUM('tecnico', 'licenciatura', 'ingenieria', 'maestria', 'doctorado') DEFAULT 'licenciatura',
    activo TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de convocatorias (contenedor general)
CREATE TABLE IF NOT EXISTS convocatorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL COMMENT 'Ej: Prácticas Profesionales Periodo 1',
    descripcion TEXT COMMENT 'Descripción general de la convocatoria',
    tipo_contrato ENUM('tiempo_completo', 'medio_tiempo', 'temporal', 'practicas') DEFAULT 'practicas',
    salario_min DECIMAL(10,2),
    salario_max DECIMAL(10,2),
    fecha_inicio DATE NOT NULL,
    fecha_cierre DATE NOT NULL,
    estado ENUM('borrador', 'publicada', 'cerrada', 'cancelada') DEFAULT 'borrador',
    usuario_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de perfiles dentro de una convocatoria
CREATE TABLE IF NOT EXISTS perfiles_convocatoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    convocatoria_id INT NOT NULL,
    titulo VARCHAR(200) NOT NULL COMMENT 'Ej: Practicante de Ingeniería Civil',
    area_id INT NOT NULL COMMENT 'Ej: Operación y Mantenimiento',
    descripcion TEXT NOT NULL,
    requisitos TEXT NOT NULL,
    responsabilidades TEXT,
    experiencia_requerida INT DEFAULT 0 COMMENT 'Años de experiencia',
    vacantes INT DEFAULT 1,
    activo TINYINT(1) DEFAULT 1,
    orden INT DEFAULT 0 COMMENT 'Orden de visualización',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (convocatoria_id) REFERENCES convocatorias(id) ON DELETE CASCADE,
    FOREIGN KEY (area_id) REFERENCES areas(id),
    INDEX idx_perfil_convocatoria (convocatoria_id),
    INDEX idx_perfil_area (area_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de relación perfil-carrera (muchos a muchos)
CREATE TABLE IF NOT EXISTS perfil_carreras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    perfil_id INT NOT NULL,
    carrera_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (perfil_id) REFERENCES perfiles_convocatoria(id) ON DELETE CASCADE,
    FOREIGN KEY (carrera_id) REFERENCES carreras(id) ON DELETE CASCADE,
    UNIQUE KEY unique_perfil_carrera (perfil_id, carrera_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de candidatos
CREATE TABLE IF NOT EXISTS candidatos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido_paterno VARCHAR(100) NOT NULL,
    apellido_materno VARCHAR(100),
    email VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    fecha_nacimiento DATE,
    direccion TEXT,
    ciudad VARCHAR(100),
    estado VARCHAR(100),
    codigo_postal VARCHAR(10),
    carrera_id INT,
    nivel_estudios ENUM('secundaria', 'preparatoria', 'tecnico', 'licenciatura', 'maestria', 'doctorado'),
    institucion VARCHAR(200),
    anio_graduacion YEAR,
    experiencia_laboral TEXT,
    habilidades TEXT,
    cv_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (carrera_id) REFERENCES carreras(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de postulaciones (ahora relacionadas con perfiles específicos)
CREATE TABLE IF NOT EXISTS postulaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    convocatoria_id INT NOT NULL COMMENT 'Referencia a la convocatoria general',
    perfil_id INT NOT NULL COMMENT 'Referencia al perfil específico',
    candidato_id INT NOT NULL,
    estado ENUM('pendiente', 'revision', 'entrevista', 'aceptado', 'rechazado') DEFAULT 'pendiente',
    puntuacion INT DEFAULT 0,
    comentarios TEXT,
    fecha_postulacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (convocatoria_id) REFERENCES convocatorias(id) ON DELETE CASCADE,
    FOREIGN KEY (perfil_id) REFERENCES perfiles_convocatoria(id) ON DELETE CASCADE,
    FOREIGN KEY (candidato_id) REFERENCES candidatos(id) ON DELETE CASCADE,
    UNIQUE KEY unique_postulacion (perfil_id, candidato_id),
    INDEX idx_postulacion_perfil (perfil_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar usuario administrador por defecto
-- Password: admin123 (hasheado con password_hash)
INSERT INTO usuarios (nombre, email, password, rol) VALUES
('Administrador', 'admin@seleccion.com', '$2y$12$i/fI3ro.fxOa7Ka41e2pAOy7NK5lUjLEZAjYp5iNP5PrO7Of5hlhu', 'admin');

-- Insertar algunas áreas de ejemplo
INSERT INTO areas (nombre, descripcion) VALUES
('Recursos Humanos', 'Área de gestión del talento humano'),
('Tecnología', 'Área de desarrollo y sistemas'),
('Administración', 'Área administrativa y financiera'),
('Ventas', 'Área comercial y ventas'),
('Marketing', 'Área de marketing y comunicación'),
('Operación y Mantenimiento', 'Área de operaciones y mantenimiento'),
('Producción', 'Área de producción y manufactura'),
('Logística', 'Área de logística y almacenamiento');

-- Insertar algunas carreras de ejemplo
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

-- Ejemplo de convocatoria con múltiples perfiles
INSERT INTO convocatorias (titulo, descripcion, tipo_contrato, fecha_inicio, fecha_cierre, estado, usuario_id) VALUES
('Prácticas Profesionales Periodo 1 - 2025', 'Convocatoria para prácticas profesionales en diferentes áreas de la empresa', 'practicas', '2025-01-15', '2025-02-15', 'publicada', 1);

-- Perfiles de ejemplo para la convocatoria
INSERT INTO perfiles_convocatoria (convocatoria_id, titulo, area_id, descripcion, requisitos, responsabilidades, experiencia_requerida, vacantes, orden) VALUES
(1, 'Practicante de Ingeniería Civil', 6, 'Apoyo en proyectos de infraestructura y mantenimiento', 'Estudiante activo de Ingeniería Civil o carreras afines. Conocimientos en AutoCAD y software de diseño.', 'Apoyar en la elaboración de planos, supervisión de obras, y control de proyectos.', 0, 1, 1),
(1, 'Practicante de Ingeniería Agrícola', 7, 'Apoyo en procesos de producción agrícola', 'Estudiante activo de Ingeniería Agrícola, Agronómica o carreras afines. Conocimientos en sistemas de riego.', 'Apoyar en el control de cultivos, sistemas de riego, y mejora de procesos productivos.', 0, 1, 2),
(1, 'Practicante de Ingeniería Industrial', 7, 'Apoyo en optimización de procesos productivos', 'Estudiante activo de Ingeniería Industrial o carreras afines. Conocimientos en herramientas de calidad.', 'Apoyar en análisis de procesos, control de calidad, y mejora continua.', 0, 2, 3);

-- Asignar carreras a los perfiles
-- Perfil 1: Ingeniería Civil
INSERT INTO perfil_carreras (perfil_id, carrera_id) VALUES (1, 11);

-- Perfil 2: Ingeniería Agrícola y Agronómica
INSERT INTO perfil_carreras (perfil_id, carrera_id) VALUES (2, 12), (2, 13);

-- Perfil 3: Ingeniería Industrial
INSERT INTO perfil_carreras (perfil_id, carrera_id) VALUES (3, 7);
