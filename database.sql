-- Base de datos para Sistema de Selección de Personal
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

-- Tabla de convocatorias
CREATE TABLE IF NOT EXISTS convocatorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    area_id INT NOT NULL,
    descripcion TEXT NOT NULL,
    requisitos TEXT NOT NULL,
    responsabilidades TEXT,
    salario_min DECIMAL(10,2),
    salario_max DECIMAL(10,2),
    tipo_contrato ENUM('tiempo_completo', 'medio_tiempo', 'temporal', 'practicas') DEFAULT 'tiempo_completo',
    experiencia_requerida INT DEFAULT 0 COMMENT 'Años de experiencia',
    fecha_inicio DATE NOT NULL,
    fecha_cierre DATE NOT NULL,
    vacantes INT DEFAULT 1,
    estado ENUM('borrador', 'publicada', 'cerrada', 'cancelada') DEFAULT 'borrador',
    usuario_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (area_id) REFERENCES areas(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de relación convocatoria-carrera (muchos a muchos)
CREATE TABLE IF NOT EXISTS convocatoria_carreras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    convocatoria_id INT NOT NULL,
    carrera_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (convocatoria_id) REFERENCES convocatorias(id) ON DELETE CASCADE,
    FOREIGN KEY (carrera_id) REFERENCES carreras(id) ON DELETE CASCADE,
    UNIQUE KEY unique_convocatoria_carrera (convocatoria_id, carrera_id)
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

-- Tabla de postulaciones
CREATE TABLE IF NOT EXISTS postulaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    convocatoria_id INT NOT NULL,
    candidato_id INT NOT NULL,
    estado ENUM('pendiente', 'revision', 'entrevista', 'aceptado', 'rechazado') DEFAULT 'pendiente',
    puntuacion INT DEFAULT 0,
    comentarios TEXT,
    fecha_postulacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (convocatoria_id) REFERENCES convocatorias(id) ON DELETE CASCADE,
    FOREIGN KEY (candidato_id) REFERENCES candidatos(id) ON DELETE CASCADE,
    UNIQUE KEY unique_postulacion (convocatoria_id, candidato_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar usuario administrador por defecto
-- Password: admin123 (hasheado con password_hash)
INSERT INTO usuarios (nombre, email, password, rol) VALUES
('Administrador', 'admin@seleccion.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Insertar algunas áreas de ejemplo
INSERT INTO areas (nombre, descripcion) VALUES
('Recursos Humanos', 'Área de gestión del talento humano'),
('Tecnología', 'Área de desarrollo y sistemas'),
('Administración', 'Área administrativa y financiera'),
('Ventas', 'Área comercial y ventas'),
('Marketing', 'Área de marketing y comunicación');

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
('Derecho', 'licenciatura');
