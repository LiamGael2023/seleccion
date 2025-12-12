-- Script para corregir la contraseña del usuario admin
-- Ejecuta este script si ya importaste la base de datos y no puedes iniciar sesión

USE seleccion_personal;

-- Actualizar contraseña del administrador
UPDATE usuarios
SET password = '$2y$12$i/fI3ro.fxOa7Ka41e2pAOy7NK5lUjLEZAjYp5iNP5PrO7Of5hlhu'
WHERE email = 'admin@seleccion.com';

-- Verificar que se actualizó correctamente
SELECT id, nombre, email, rol, 'Contraseña actualizada correctamente' as status
FROM usuarios
WHERE email = 'admin@seleccion.com';
