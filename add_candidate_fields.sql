-- Script para agregar nuevos campos a la tabla candidatos
-- Fecha: 2025-12-12
-- Descripción: Agrega campos para sexo, discapacidad, información SUNEDU y foto

USE seleccion;

-- Agregar campo de sexo
ALTER TABLE candidatos
ADD COLUMN sexo ENUM('masculino', 'femenino') DEFAULT NULL
AFTER fecha_nacimiento;

-- Agregar campos de discapacidad
ALTER TABLE candidatos
ADD COLUMN presenta_discapacidad ENUM('si', 'no') DEFAULT 'no'
AFTER sexo;

ALTER TABLE candidatos
ADD COLUMN tipo_discapacidad VARCHAR(200) DEFAULT NULL
AFTER presenta_discapacidad;

-- Agregar campo de carrera universitaria (nombre completo)
ALTER TABLE candidatos
ADD COLUMN carrera_universitaria VARCHAR(200) DEFAULT NULL
AFTER carrera_id;

-- Agregar campos de egreso SUNEDU
ALTER TABLE candidatos
ADD COLUMN mes_egresado_sunedu INT(2) DEFAULT NULL
AFTER anio_graduacion;

ALTER TABLE candidatos
ADD COLUMN anio_egresado_sunedu YEAR DEFAULT NULL
AFTER mes_egresado_sunedu;

-- Agregar campo para foto/imagen del candidato
ALTER TABLE candidatos
ADD COLUMN foto_path VARCHAR(255) DEFAULT NULL
AFTER cv_path;

-- Agregar comentarios para documentar los campos
ALTER TABLE candidatos
MODIFY COLUMN sexo ENUM('masculino', 'femenino') DEFAULT NULL COMMENT 'Sexo del candidato',
MODIFY COLUMN presenta_discapacidad ENUM('si', 'no') DEFAULT 'no' COMMENT 'Indica si presenta discapacidad',
MODIFY COLUMN tipo_discapacidad VARCHAR(200) DEFAULT NULL COMMENT 'Tipo de discapacidad si presenta',
MODIFY COLUMN carrera_universitaria VARCHAR(200) DEFAULT NULL COMMENT 'Nombre de la carrera universitaria',
MODIFY COLUMN mes_egresado_sunedu INT(2) DEFAULT NULL COMMENT 'Mes de egreso según SUNEDU (1-12)',
MODIFY COLUMN anio_egresado_sunedu YEAR DEFAULT NULL COMMENT 'Año de egreso según SUNEDU',
MODIFY COLUMN foto_path VARCHAR(255) DEFAULT NULL COMMENT 'Ruta de la foto del candidato';
