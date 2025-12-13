-- Agregar jerarquía a tabla áreas
ALTER TABLE areas
ADD COLUMN area_padre_id INT DEFAULT NULL AFTER nombre,
ADD CONSTRAINT fk_areas_padre
    FOREIGN KEY (area_padre_id)
    REFERENCES areas(id)
    ON DELETE CASCADE;

-- Insertar Subgerencias (Áreas Padre)
INSERT INTO areas (nombre, descripcion, activo) VALUES
('Subgerencia de Desarrollo Agrícola', 'Producción agrícola, biotecnología y medio ambiente', 1),
('Subgerencia de Operación y Mantenimiento (SGOM)', 'Operación de infraestructura hidráulica y mantenimiento', 1),
('Subgerencia de Agua Potable y Energía Eléctrica', 'Gestión de PTAP y centrales hidroeléctricas', 1),
('Subgerencia de Obras', 'Supervisión y liquidación de obras', 1),
('Subgerencia de Estudios', 'Estudios de preinversión y expedientes técnicos', 1),
('Subgerencia de Gestión de Tierras', 'Saneamiento físico legal y catastro', 1),
('Oficina de Administración', 'Áreas administrativas y de soporte', 1);

-- Insertar Divisiones/Áreas de la Subgerencia de Desarrollo Agrícola
INSERT INTO areas (nombre, descripcion, area_padre_id, activo) VALUES
('División de Biotecnología', 'Laboratorios de producción in vitro, plantines y frutales', (SELECT id FROM (SELECT id FROM areas WHERE nombre = 'Subgerencia de Desarrollo Agrícola') as tmp), 1),
('División de Medio Ambiente', 'Monitoreo de cuencas y calidad ambiental', (SELECT id FROM (SELECT id FROM areas WHERE nombre = 'Subgerencia de Desarrollo Agrícola') as tmp), 1),
('Parcelas Experimentales', 'Áreas de campo - Campamento San José para validación de cultivos', (SELECT id FROM (SELECT id FROM areas WHERE nombre = 'Subgerencia de Desarrollo Agrícola') as tmp), 1),
('Promoción Agraria', 'Capacitación a agricultores', (SELECT id FROM (SELECT id FROM areas WHERE nombre = 'Subgerencia de Desarrollo Agrícola') as tmp), 1);

-- Insertar Divisiones/Áreas de SGOM
INSERT INTO areas (nombre, descripcion, area_padre_id, activo) VALUES
('División de Operación de la Infraestructura Hidráulica', 'Control de compuertas, caudales y distribución de agua', (SELECT id FROM (SELECT id FROM areas WHERE nombre = 'Subgerencia de Operación y Mantenimiento (SGOM)') as tmp), 1),
('División de Mantenimiento', 'Reparación de canales, túneles y caminos', (SELECT id FROM (SELECT id FROM areas WHERE nombre = 'Subgerencia de Operación y Mantenimiento (SGOM)') as tmp), 1),
('Área de Equipo Mecánico', 'Gestión de maquinaria pesada', (SELECT id FROM (SELECT id FROM areas WHERE nombre = 'Subgerencia de Operación y Mantenimiento (SGOM)') as tmp), 1);

-- Insertar Divisiones/Áreas de Agua Potable y Energía
INSERT INTO areas (nombre, descripcion, area_padre_id, activo) VALUES
('Planta de Tratamiento de Agua Potable (PTAP)', 'Producción de agua potable - Alto Moche', (SELECT id FROM (SELECT id FROM areas WHERE nombre = 'Subgerencia de Agua Potable y Energía Eléctrica') as tmp), 1),
('División de Energía Eléctrica', 'Gestión de mini centrales hidroeléctricas', (SELECT id FROM (SELECT id FROM areas WHERE nombre = 'Subgerencia de Agua Potable y Energía Eléctrica') as tmp), 1);

-- Insertar Divisiones/Áreas de Obras
INSERT INTO areas (nombre, descripcion, area_padre_id, activo) VALUES
('División de Supervisión de Obras', 'Control de constructoras', (SELECT id FROM (SELECT id FROM areas WHERE nombre = 'Subgerencia de Obras') as tmp), 1),
('División de Liquidación de Obras', 'Cierre financiero y técnico de proyectos', (SELECT id FROM (SELECT id FROM areas WHERE nombre = 'Subgerencia de Obras') as tmp), 1);

-- Insertar Divisiones/Áreas de Estudios
INSERT INTO areas (nombre, descripcion, area_padre_id, activo) VALUES
('Área de Estudios de Preinversión', 'Perfiles y fichas técnicas', (SELECT id FROM (SELECT id FROM areas WHERE nombre = 'Subgerencia de Estudios') as tmp), 1),
('Área de Expedientes Técnicos', 'Planos y costos detallados para futuras obras', (SELECT id FROM (SELECT id FROM areas WHERE nombre = 'Subgerencia de Estudios') as tmp), 1);

-- Insertar Divisiones/Áreas de Gestión de Tierras
INSERT INTO areas (nombre, descripcion, area_padre_id, activo) VALUES
('Área de Saneamiento Físico Legal', 'Titulación y ordenamiento de terrenos', (SELECT id FROM (SELECT id FROM areas WHERE nombre = 'Subgerencia de Gestión de Tierras') as tmp), 1),
('Área de Catastro', 'Mapas y delimitación de predios (GIS)', (SELECT id FROM (SELECT id FROM areas WHERE nombre = 'Subgerencia de Gestión de Tierras') as tmp), 1);

-- Insertar Áreas Administrativas
INSERT INTO areas (nombre, descripcion, area_padre_id, activo) VALUES
('Unidad de Recursos Humanos (RRHH)', 'Gestión de personal', (SELECT id FROM (SELECT id FROM areas WHERE nombre = 'Oficina de Administración') as tmp), 1),
('Unidad de Logística', 'Compras y patrimonio', (SELECT id FROM (SELECT id FROM areas WHERE nombre = 'Oficina de Administración') as tmp), 1),
('Unidad de Contabilidad', 'Gestión contable', (SELECT id FROM (SELECT id FROM areas WHERE nombre = 'Oficina de Administración') as tmp), 1),
('Unidad de Tesorería', 'Gestión financiera', (SELECT id FROM (SELECT id FROM areas WHERE nombre = 'Oficina de Administración') as tmp), 1),
('Unidad de Tecnología de la Información (UTI)', 'Servidores y sistemas informáticos', (SELECT id FROM (SELECT id FROM areas WHERE nombre = 'Oficina de Administración') as tmp), 1),
('Trámite Documentario y Archivo Central', 'Gestión documental y cumplimiento AGN', (SELECT id FROM (SELECT id FROM areas WHERE nombre = 'Oficina de Administración') as tmp), 1);
