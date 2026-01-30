-- Migración para agregar tabla de anexos a convocatorias
-- Fecha: 2025-01-18
-- Descripción: Permite subir documentos PDF como anexos que los postulantes deben llenar

USE seleccion_personal;

-- Crear tabla de anexos
CREATE TABLE IF NOT EXISTS convocatoria_anexos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    convocatoria_id INT NOT NULL,
    nombre_original VARCHAR(255) NOT NULL COMMENT 'Nombre original del archivo',
    nombre_archivo VARCHAR(255) NOT NULL COMMENT 'Nombre único del archivo en el servidor',
    ruta_archivo VARCHAR(500) NOT NULL COMMENT 'Ruta completa del archivo',
    descripcion TEXT COMMENT 'Descripción del anexo',
    tamanio INT NOT NULL COMMENT 'Tamaño del archivo en bytes',
    orden INT DEFAULT 0 COMMENT 'Orden de visualización',
    obligatorio TINYINT(1) DEFAULT 1 COMMENT 'Si es obligatorio descargarlo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (convocatoria_id) REFERENCES convocatorias(id) ON DELETE CASCADE,
    INDEX idx_convocatoria (convocatoria_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Crear directorio para almacenar anexos (esto debe hacerse manualmente)
-- mkdir -p public/uploads/anexos
-- chmod 755 public/uploads/anexos

-- Agregar comentario a la tabla de convocatorias para documentar la relación
ALTER TABLE convocatorias
COMMENT = 'Convocatorias generales. Los anexos PDF se almacenan en convocatoria_anexos';

PRINT 'Tabla convocatoria_anexos creada exitosamente';
PRINT 'No olvides crear el directorio: public/uploads/anexos';
