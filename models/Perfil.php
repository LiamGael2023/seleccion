<?php
require_once BASE_PATH . '/core/Model.php';

class Perfil extends Model {
    protected $table = 'perfiles_convocatoria';

    public function getByConvocatoria($convocatoriaId) {
        $sql = "SELECT p.*, a.nombre as area_nombre
                FROM {$this->table} p
                LEFT JOIN areas a ON p.area_id = a.id
                WHERE p.convocatoria_id = :convocatoria_id
                AND p.activo = 1
                ORDER BY p.orden ASC, p.id ASC";
        return $this->query($sql, ['convocatoria_id' => $convocatoriaId]);
    }

    public function getById($id) {
        $sql = "SELECT p.*, a.nombre as area_nombre
                FROM {$this->table} p
                LEFT JOIN areas a ON p.area_id = a.id
                WHERE p.id = :id LIMIT 1";
        $result = $this->query($sql, ['id' => $id]);
        return $result[0] ?? null;
    }

    public function getCarreras($perfilId) {
        $sql = "SELECT c.* FROM carreras c
                INNER JOIN perfil_carreras pc ON c.id = pc.carrera_id
                WHERE pc.perfil_id = :id";
        return $this->query($sql, ['id' => $perfilId]);
    }

    public function addCarrera($perfilId, $carreraId) {
        $sql = "INSERT INTO perfil_carreras (perfil_id, carrera_id)
                VALUES (:perfil_id, :carrera_id)";
        return $this->execute($sql, [
            'perfil_id' => $perfilId,
            'carrera_id' => $carreraId
        ]);
    }

    public function removeAllCarreras($perfilId) {
        $sql = "DELETE FROM perfil_carreras WHERE perfil_id = :id";
        return $this->execute($sql, ['id' => $perfilId]);
    }

    public function getPostulaciones($perfilId) {
        $sql = "SELECT p.*,
                CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) as candidato_nombre,
                c.email as candidato_email,
                c.telefono as candidato_telefono,
                ca.nombre as carrera_nombre
                FROM postulaciones p
                INNER JOIN candidatos c ON p.candidato_id = c.id
                LEFT JOIN carreras ca ON c.carrera_id = ca.id
                WHERE p.perfil_id = :id
                ORDER BY p.fecha_postulacion DESC";
        return $this->query($sql, ['id' => $perfilId]);
    }

    public function countPostulaciones($perfilId) {
        $sql = "SELECT COUNT(*) as total FROM postulaciones WHERE perfil_id = :id";
        $result = $this->query($sql, ['id' => $perfilId]);
        return $result[0]['total'] ?? 0;
    }
}
