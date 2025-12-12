<?php
require_once BASE_PATH . '/core/Model.php';

class Postulacion extends Model {
    protected $table = 'postulaciones';

    public function existePostulacion($perfilId, $candidatoId) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}
                WHERE perfil_id = :perfil_id
                AND candidato_id = :candidato_id";
        $result = $this->query($sql, [
            'perfil_id' => $perfilId,
            'candidato_id' => $candidatoId
        ]);
        return $result[0]['total'] > 0;
    }

    public function getEstadisticas() {
        $sql = "SELECT estado, COUNT(*) as total
                FROM {$this->table}
                GROUP BY estado";
        return $this->query($sql);
    }

    public function getByPerfil($perfilId) {
        $sql = "SELECT p.*,
                CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) as candidato_nombre,
                c.email as candidato_email,
                c.telefono as candidato_telefono,
                ca.nombre as carrera_nombre
                FROM {$this->table} p
                INNER JOIN candidatos c ON p.candidato_id = c.id
                LEFT JOIN carreras ca ON c.carrera_id = ca.id
                WHERE p.perfil_id = :perfil_id
                ORDER BY p.fecha_postulacion DESC";
        return $this->query($sql, ['perfil_id' => $perfilId]);
    }
}
