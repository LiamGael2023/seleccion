-- Migration script to ensure proper foreign key constraints for V2 multi-profile system
-- This ensures that when a convocatoria is deleted, all related records are also deleted

-- First, check if we need to drop existing foreign keys and recreate them with ON DELETE CASCADE

-- For perfiles_convocatoria table
ALTER TABLE perfiles_convocatoria
DROP FOREIGN KEY IF EXISTS perfiles_convocatoria_ibfk_1;

ALTER TABLE perfiles_convocatoria
ADD CONSTRAINT perfiles_convocatoria_ibfk_1
FOREIGN KEY (convocatoria_id) REFERENCES convocatorias(id) ON DELETE CASCADE;

-- For postulaciones table
ALTER TABLE postulaciones
DROP FOREIGN KEY IF EXISTS postulaciones_ibfk_1;

ALTER TABLE postulaciones
DROP FOREIGN KEY IF EXISTS postulaciones_ibfk_2;

ALTER TABLE postulaciones
ADD CONSTRAINT postulaciones_ibfk_1
FOREIGN KEY (convocatoria_id) REFERENCES convocatorias(id) ON DELETE CASCADE;

-- Check if perfil_id column exists (V2 schema)
-- If it exists, ensure it has proper constraint
SET @dbname = DATABASE();
SET @tablename = 'postulaciones';
SET @columnname = 'perfil_id';
SET @hasPerfil = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = @dbname
    AND TABLE_NAME = @tablename
    AND COLUMN_NAME = @columnname);

-- Only add perfil_id foreign key if the column exists (V2 schema)
-- You may need to run this conditionally based on your schema version
-- Uncomment the following lines if you're using V2 schema:

-- ALTER TABLE postulaciones
-- ADD CONSTRAINT postulaciones_ibfk_2
-- FOREIGN KEY (perfil_id) REFERENCES perfiles_convocatoria(id) ON DELETE CASCADE;

-- For perfil_carreras table (V2 only)
-- Uncomment if using V2 schema:

-- ALTER TABLE perfil_carreras
-- DROP FOREIGN KEY IF EXISTS perfil_carreras_ibfk_1;

-- ALTER TABLE perfil_carreras
-- ADD CONSTRAINT perfil_carreras_ibfk_1
-- FOREIGN KEY (perfil_id) REFERENCES perfiles_convocatoria(id) ON DELETE CASCADE;

-- For convocatoria_carreras table (V1 schema)
ALTER TABLE convocatoria_carreras
DROP FOREIGN KEY IF EXISTS convocatoria_carreras_ibfk_1;

ALTER TABLE convocatoria_carreras
ADD CONSTRAINT convocatoria_carreras_ibfk_1
FOREIGN KEY (convocatoria_id) REFERENCES convocatorias(id) ON DELETE CASCADE;
