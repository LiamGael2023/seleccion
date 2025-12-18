<?php
require_once BASE_PATH . '/core/Model.php';

/**
 * Modelo para gestionar anexos de convocatorias
 */
class ConvocatoriaAnexo extends Model {
    protected $table = 'convocatoria_anexos';

    /**
     * Obtener todos los anexos de una convocatoria
     */
    public function getByConvocatoria($convocatoriaId) {
        $sql = "SELECT * FROM {$this->table}
                WHERE convocatoria_id = :convocatoria_id
                ORDER BY orden ASC, created_at ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['convocatoria_id' => $convocatoriaId]);

        return $stmt->fetchAll();
    }

    /**
     * Crear un nuevo anexo
     */
    public function create($data) {
        $sql = "INSERT INTO {$this->table}
                (convocatoria_id, nombre_original, nombre_archivo, ruta_archivo, descripcion, tamanio, orden, obligatorio)
                VALUES
                (:convocatoria_id, :nombre_original, :nombre_archivo, :ruta_archivo, :descripcion, :tamanio, :orden, :obligatorio)";

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            'convocatoria_id' => $data['convocatoria_id'],
            'nombre_original' => $data['nombre_original'],
            'nombre_archivo' => $data['nombre_archivo'],
            'ruta_archivo' => $data['ruta_archivo'],
            'descripcion' => $data['descripcion'] ?? null,
            'tamanio' => $data['tamanio'],
            'orden' => $data['orden'] ?? 0,
            'obligatorio' => $data['obligatorio'] ?? 1
        ]);

        return $result ? $this->db->lastInsertId() : false;
    }

    /**
     * Obtener un anexo por ID
     */
    public function find($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }

    /**
     * Eliminar un anexo
     */
    public function delete($id) {
        // Primero obtener la información del archivo para eliminarlo físicamente
        $anexo = $this->find($id);

        if ($anexo) {
            // Eliminar archivo físico
            $rutaCompleta = BASE_PATH . '/' . $anexo['ruta_archivo'];
            if (file_exists($rutaCompleta)) {
                unlink($rutaCompleta);
            }

            // Eliminar registro de la base de datos
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['id' => $id]);
        }

        return false;
    }

    /**
     * Actualizar descripción y orden de un anexo
     */
    public function update($id, $data) {
        $sql = "UPDATE {$this->table}
                SET descripcion = :descripcion,
                    orden = :orden,
                    obligatorio = :obligatorio
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'descripcion' => $data['descripcion'] ?? null,
            'orden' => $data['orden'] ?? 0,
            'obligatorio' => $data['obligatorio'] ?? 1
        ]);
    }

    /**
     * Contar anexos de una convocatoria
     */
    public function countByConvocatoria($convocatoriaId) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE convocatoria_id = :convocatoria_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['convocatoria_id' => $convocatoriaId]);
        $result = $stmt->fetch();

        return $result['total'] ?? 0;
    }

    /**
     * Guardar un archivo PDF subido
     */
    public function guardarArchivo($file, $convocatoriaId) {
        // Validar que sea PDF
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if ($extension !== 'pdf') {
            return ['success' => false, 'error' => 'Solo se permiten archivos PDF'];
        }

        // Validar tamaño (máximo 10MB)
        $maxSize = 10 * 1024 * 1024; // 10MB en bytes
        if ($file['size'] > $maxSize) {
            return ['success' => false, 'error' => 'El archivo no debe superar los 10MB'];
        }

        // Generar nombre único
        $nombreOriginal = $file['name'];
        $nombreUnico = 'anexo_' . $convocatoriaId . '_' . time() . '_' . uniqid() . '.pdf';
        $rutaRelativa = 'public/uploads/anexos/' . $nombreUnico;
        $rutaCompleta = BASE_PATH . '/' . $rutaRelativa;

        // Mover archivo
        if (move_uploaded_file($file['tmp_name'], $rutaCompleta)) {
            return [
                'success' => true,
                'nombre_original' => $nombreOriginal,
                'nombre_archivo' => $nombreUnico,
                'ruta_archivo' => $rutaRelativa,
                'tamanio' => $file['size']
            ];
        }

        return ['success' => false, 'error' => 'Error al subir el archivo'];
    }

    /**
     * Formatear tamaño de archivo
     */
    public static function formatearTamanio($bytes) {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' bytes';
    }
}
