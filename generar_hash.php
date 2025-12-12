<?php
/**
 * Script temporal para generar hash de contraseña
 * Ejecuta este archivo y copia el hash generado
 */

$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "===========================================\n";
echo "Generador de Hash de Contraseña\n";
echo "===========================================\n\n";
echo "Contraseña: " . $password . "\n";
echo "Hash: " . $hash . "\n\n";
echo "===========================================\n";
echo "Copia este hash para actualizar la base de datos\n";
echo "===========================================\n";
?>
