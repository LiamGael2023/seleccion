-- Crear tabla de categorías de carreras
CREATE TABLE IF NOT EXISTS categorias_carreras (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT,
    activo TINYINT(1) DEFAULT 1,
    orden INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Agregar columna de categoría a la tabla carreras
ALTER TABLE carreras
ADD COLUMN categoria_id INT DEFAULT NULL AFTER nivel,
ADD CONSTRAINT fk_carreras_categoria
    FOREIGN KEY (categoria_id)
    REFERENCES categorias_carreras(id)
    ON DELETE SET NULL;

-- Insertar categorías comunes
INSERT INTO categorias_carreras (nombre, descripcion, orden) VALUES
('Ingeniería', 'Carreras del área de ingeniería', 1),
('Arquitectura y Diseño', 'Carreras de arquitectura, urbanismo y diseño', 2),
('Ciencias de la Salud', 'Carreras del área de salud y medicina', 3),
('Ciencias Sociales', 'Carreras de ciencias sociales y humanidades', 4),
('Administración y Negocios', 'Carreras de administración, economía y negocios', 5),
('Educación', 'Carreras de educación y pedagogía', 6),
('Derecho', 'Carreras del área legal', 7),
('Comunicaciones', 'Carreras de comunicación, periodismo y publicidad', 8),
('Arte y Cultura', 'Carreras artísticas y culturales', 9),
('Ciencias Exactas', 'Carreras de matemáticas, física, química', 10),
('Tecnología de la Información', 'Carreras de informática y sistemas', 11),
('Otras', 'Otras carreras no clasificadas', 99);
