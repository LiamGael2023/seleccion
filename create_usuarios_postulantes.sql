-- Crear tabla para usuarios postulantes
-- Los postulantes deben registrarse antes de poder postularse

CREATE TABLE IF NOT EXISTS usuarios_postulantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dni VARCHAR(8) NOT NULL UNIQUE COMMENT 'DNI del postulante (usado como usuario)',
    email VARCHAR(100) NOT NULL UNIQUE COMMENT 'Email único del postulante',
    password VARCHAR(255) NOT NULL COMMENT 'Contraseña hasheada',
    nombres VARCHAR(200) NOT NULL COMMENT 'Nombres del postulante desde RENIEC',
    apellido_paterno VARCHAR(100) NOT NULL COMMENT 'Apellido paterno desde RENIEC',
    apellido_materno VARCHAR(100) COMMENT 'Apellido materno desde RENIEC',
    estado_reniec VARCHAR(50) COMMENT 'Estado del DNI en RENIEC',
    condicion_reniec VARCHAR(50) COMMENT 'Condición del DNI en RENIEC',
    direccion VARCHAR(255) COMMENT 'Dirección desde RENIEC',
    ubigeo VARCHAR(10) COMMENT 'Ubigeo desde RENIEC',
    departamento VARCHAR(100) COMMENT 'Departamento desde RENIEC',
    provincia VARCHAR(100) COMMENT 'Provincia desde RENIEC',
    distrito VARCHAR(100) COMMENT 'Distrito desde RENIEC',
    activo TINYINT(1) DEFAULT 1 COMMENT 'Usuario activo o inactivo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_dni (dni),
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Agregar campo usuario_postulante_id a la tabla candidatos
-- Esto vincula cada postulación con el usuario registrado
ALTER TABLE candidatos
ADD COLUMN usuario_postulante_id INT DEFAULT NULL
AFTER id;

ALTER TABLE candidatos
ADD CONSTRAINT fk_candidato_usuario_postulante
FOREIGN KEY (usuario_postulante_id) REFERENCES usuarios_postulantes(id) ON DELETE SET NULL;

-- Índice para mejorar búsquedas
ALTER TABLE candidatos
ADD INDEX idx_usuario_postulante (usuario_postulante_id);
