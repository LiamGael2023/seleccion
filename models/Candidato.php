<?php
require_once BASE_PATH . '/core/Model.php';

class Candidato extends Model {
    protected $table = 'candidatos';

    public function getAllWithDetails() {
        $sql = "SELECT c.*, ca.nombre as carrera_nombre
                FROM {$this->table} c
                LEFT JOIN carreras ca ON c.carrera_id = ca.id
                ORDER BY c.created_at DESC";
        return $this->query($sql);
    }

    public function getByEmail($email) {
        return $this->where('email', $email);
    }

    public function uploadCV($file, $candidatoId) {
        $uploadDir = BASE_PATH . '/public/uploads/cv/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = 'cv_' . $candidatoId . '_' . time() . '.' . $extension;
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            return 'uploads/cv/' . $fileName;
        }
        return false;
    }

    public function uploadFoto($file, $candidatoId) {
        $uploadDir = BASE_PATH . '/public/uploads/fotos/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Validar que sea una imagen
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }

        // Validar tamaño (máx 2MB)
        if ($file['size'] > 2 * 1024 * 1024) {
            return false;
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = 'foto_' . $candidatoId . '_' . time() . '.' . $extension;
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            return 'uploads/fotos/' . $fileName;
        }
        return false;
    }
}
