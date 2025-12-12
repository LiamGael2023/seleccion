-- Migración para soportar múltiples perfiles por convocatoria
-- Ejecuta este script DESPUÉS de haber ejecutado database.sql

USE seleccion_personal;

-- Crear tabla de perfiles de convocatoria
CREATE TABLE IF NOT EXISTS perfiles_convocatoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    convocatoria_id INT NOT NULL,
    titulo VARCHAR(200) NOT NULL,
    area_id INT NOT NULL,
    descripcion TEXT NOT NULL,
    requisitos TEXT NOT NULL,
    responsabilidades TEXT,
    experiencia_requerida INT DEFAULT 0,
    vacantes INT DEFAULT 1,
    activo TINYINT(1) DEFAULT 1,
    orden INT DEFAULT 0 COMMENT 'Orden de visualización',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (convocatoria_id) REFERENCES convocatorias(id) ON DELETE CASCADE,
    FOREIGN KEY (area_id) REFERENCES areas(id)
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

-- Modificar tabla de postulaciones para relacionar con perfiles
-- Primero eliminar la constraint existente
ALTER TABLE postulaciones DROP FOREIGN KEY postulaciones_ibfk_1;

-- Agregar nueva columna para perfil_id
ALTER TABLE postulaciones ADD COLUMN perfil_id INT NULL AFTER convocatoria_id;

-- Agregar índice compuesto único actualizado
ALTER TABLE postulaciones DROP INDEX unique_postulacion;
ALTER TABLE postulaciones ADD UNIQUE KEY unique_postulacion (perfil_id, candidato_id);

-- Agregar foreign key para perfil_id
ALTER TABLE postulaciones ADD FOREIGN KEY (perfil_id) REFERENCES perfiles_convocatoria(id) ON DELETE CASCADE;
ALTER TABLE postulaciones ADD FOREIGN KEY (convocatoria_id) REFERENCES convocatorias(id) ON DELETE CASCADE;

-- Modificar tabla de convocatorias para remover campos que ahora están en perfiles
-- (Mantenemos algunos campos para compatibilidad pero ya no serán usados directamente)

-- Índices para mejorar rendimiento
CREATE INDEX idx_perfil_convocatoria ON perfiles_convocatoria(convocatoria_id);
CREATE INDEX idx_perfil_area ON perfiles_convocatoria(area_id);
CREATE INDEX idx_postulacion_perfil ON postulaciones(perfil_id);
