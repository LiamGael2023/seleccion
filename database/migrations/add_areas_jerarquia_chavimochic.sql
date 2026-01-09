-- Agregar jerarquía a tabla áreas
ALTER TABLE areas
ADD COLUMN area_padre_id INT DEFAULT NULL AFTER nombre,
ADD CONSTRAINT fk_areas_padre
    FOREIGN KEY (area_padre_id)
    REFERENCES areas(id)
    ON DELETE CASCADE;

-- PASO 1: Insertar Subgerencias (Áreas Padre) sin area_padre_id
INSERT INTO areas (nombre, descripcion, activo) VALUES
('Subgerencia de Desarrollo Agrícola', 'Producción agrícola, biotecnología y medio ambiente', 1),
('Subgerencia de Operación y Mantenimiento (SGOM)', 'Operación de infraestructura hidráulica y mantenimiento', 1),
('Subgerencia de Agua Potable y Energía Eléctrica', 'Gestión de PTAP y centrales hidroeléctricas', 1),
('Subgerencia de Obras', 'Supervisión y liquidación de obras', 1),
('Subgerencia de Estudios', 'Estudios de preinversión y expedientes técnicos', 1),
('Subgerencia de Gestión de Tierras', 'Saneamiento físico legal y catastro', 1),
('Oficina de Administración', 'Áreas administrativas y de soporte', 1);

-- PASO 2: Insertar Divisiones/Áreas hijas usando los IDs de las Subgerencias
-- Áreas de Desarrollo Agrícola
INSERT INTO areas (nombre, descripcion, area_padre_id, activo)
SELECT 'División de Biotecnología', 'Laboratorios de producción in vitro, plantines y frutales', id, 1
FROM areas WHERE nombre = 'Subgerencia de Desarrollo Agrícola';

INSERT INTO areas (nombre, descripcion, area_padre_id, activo)
SELECT 'División de Medio Ambiente', 'Monitoreo de cuencas y calidad ambiental', id, 1
FROM areas WHERE nombre = 'Subgerencia de Desarrollo Agrícola';

INSERT INTO areas (nombre, descripcion, area_padre_id, activo)
SELECT 'Parcelas Experimentales', 'Áreas de campo - Campamento San José para validación de cultivos', id, 1
FROM areas WHERE nombre = 'Subgerencia de Desarrollo Agrícola';

INSERT INTO areas (nombre, descripcion, area_padre_id, activo)
SELECT 'Promoción Agraria', 'Capacitación a agricultores', id, 1
FROM areas WHERE nombre = 'Subgerencia de Desarrollo Agrícola';

-- Áreas de SGOM
INSERT INTO areas (nombre, descripcion, area_padre_id, activo)
SELECT 'División de Operación de la Infraestructura Hidráulica', 'Control de compuertas, caudales y distribución de agua', id, 1
FROM areas WHERE nombre = 'Subgerencia de Operación y Mantenimiento (SGOM)';

INSERT INTO areas (nombre, descripcion, area_padre_id, activo)
SELECT 'División de Mantenimiento', 'Reparación de canales, túneles y caminos', id, 1
FROM areas WHERE nombre = 'Subgerencia de Operación y Mantenimiento (SGOM)';

INSERT INTO areas (nombre, descripcion, area_padre_id, activo)
SELECT 'Área de Equipo Mecánico', 'Gestión de maquinaria pesada', id, 1
FROM areas WHERE nombre = 'Subgerencia de Operación y Mantenimiento (SGOM)';

-- Áreas de Agua Potable y Energía
INSERT INTO areas (nombre, descripcion, area_padre_id, activo)
SELECT 'Planta de Tratamiento de Agua Potable (PTAP)', 'Producción de agua potable - Alto Moche', id, 1
FROM areas WHERE nombre = 'Subgerencia de Agua Potable y Energía Eléctrica';

INSERT INTO areas (nombre, descripcion, area_padre_id, activo)
SELECT 'División de Energía Eléctrica', 'Gestión de mini centrales hidroeléctricas', id, 1
FROM areas WHERE nombre = 'Subgerencia de Agua Potable y Energía Eléctrica';

-- Áreas de Obras
INSERT INTO areas (nombre, descripcion, area_padre_id, activo)
SELECT 'División de Supervisión de Obras', 'Control de constructoras', id, 1
FROM areas WHERE nombre = 'Subgerencia de Obras';

INSERT INTO areas (nombre, descripcion, area_padre_id, activo)
SELECT 'División de Liquidación de Obras', 'Cierre financiero y técnico de proyectos', id, 1
FROM areas WHERE nombre = 'Subgerencia de Obras';

-- Áreas de Estudios
INSERT INTO areas (nombre, descripcion, area_padre_id, activo)
SELECT 'Área de Estudios de Preinversión', 'Perfiles y fichas técnicas', id, 1
FROM areas WHERE nombre = 'Subgerencia de Estudios';

INSERT INTO areas (nombre, descripcion, area_padre_id, activo)
SELECT 'Área de Expedientes Técnicos', 'Planos y costos detallados para futuras obras', id, 1
FROM areas WHERE nombre = 'Subgerencia de Estudios';

-- Áreas de Gestión de Tierras
INSERT INTO areas (nombre, descripcion, area_padre_id, activo)
SELECT 'Área de Saneamiento Físico Legal', 'Titulación y ordenamiento de terrenos', id, 1
FROM areas WHERE nombre = 'Subgerencia de Gestión de Tierras';

INSERT INTO areas (nombre, descripcion, area_padre_id, activo)
SELECT 'Área de Catastro', 'Mapas y delimitación de predios (GIS)', id, 1
FROM areas WHERE nombre = 'Subgerencia de Gestión de Tierras';

-- Áreas Administrativas
INSERT INTO areas (nombre, descripcion, area_padre_id, activo)
SELECT 'Unidad de Recursos Humanos (RRHH)', 'Gestión de personal', id, 1
FROM areas WHERE nombre = 'Oficina de Administración';

INSERT INTO areas (nombre, descripcion, area_padre_id, activo)
SELECT 'Unidad de Logística', 'Compras y patrimonio', id, 1
FROM areas WHERE nombre = 'Oficina de Administración';

INSERT INTO areas (nombre, descripcion, area_padre_id, activo)
SELECT 'Unidad de Contabilidad', 'Gestión contable', id, 1
FROM areas WHERE nombre = 'Oficina de Administración';

INSERT INTO areas (nombre, descripcion, area_padre_id, activo)
SELECT 'Unidad de Tesorería', 'Gestión financiera', id, 1
FROM areas WHERE nombre = 'Oficina de Administración';

INSERT INTO areas (nombre, descripcion, area_padre_id, activo)
SELECT 'Unidad de Tecnología de la Información (UTI)', 'Servidores y sistemas informáticos', id, 1
FROM areas WHERE nombre = 'Oficina de Administración';

INSERT INTO areas (nombre, descripcion, area_padre_id, activo)
SELECT 'Trámite Documentario y Archivo Central', 'Gestión documental y cumplimiento AGN', id, 1
FROM areas WHERE nombre = 'Oficina de Administración';

