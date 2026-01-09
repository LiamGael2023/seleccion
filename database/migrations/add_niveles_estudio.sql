-- Crear tabla de niveles de estudio
CREATE TABLE IF NOT EXISTS niveles_estudio (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT,
    activo TINYINT(1) DEFAULT 1,
    orden INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar niveles de estudio predefinidos
INSERT INTO niveles_estudio (nombre, descripcion, orden) VALUES
('Técnico', 'Educación técnica o tecnológica', 1),
('Bachiller', 'Grado de bachiller universitario', 2),
('Titulado', 'Título profesional universitario', 3),
('Licenciatura', 'Grado de licenciatura', 4),
('Maestría', 'Grado de maestría o magíster', 5),
('Doctorado', 'Grado de doctorado o PhD', 6);

-- Agregar nueva columna nivel_id a carreras
ALTER TABLE carreras
ADD COLUMN nivel_id INT DEFAULT NULL AFTER categoria_id,
ADD CONSTRAINT fk_carreras_nivel
    FOREIGN KEY (nivel_id)
    REFERENCES niveles_estudio(id)
    ON DELETE SET NULL;

-- Migrar datos existentes de nivel (texto) a nivel_id (FK)
-- Esto asume que ya tienes datos en la tabla carreras
UPDATE carreras SET nivel_id = (SELECT id FROM niveles_estudio WHERE LOWER(nombre) LIKE CONCAT('%', LOWER(carreras.nivel), '%') LIMIT 1) WHERE nivel IS NOT NULL;

-- Opcional: Una vez migrados los datos, puedes eliminar la columna vieja 'nivel'
-- Descomenta la siguiente línea solo después de verificar que la migración fue exitosa
-- ALTER TABLE carreras DROP COLUMN nivel;
