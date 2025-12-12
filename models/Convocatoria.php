<?php
require_once BASE_PATH . '/core/Model.php';

class Convocatoria extends Model {
    protected $table = 'convocatorias';

    public function getAllWithDetails() {
        $sql = "SELECT c.*, u.nombre as usuario_nombre,
                (SELECT COUNT(*) FROM perfiles_convocatoria WHERE convocatoria_id = c.id AND activo = 1) as total_perfiles,
                (SELECT SUM(vacantes) FROM perfiles_convocatoria WHERE convocatoria_id = c.id AND activo = 1) as total_vacantes,
                (SELECT GROUP_CONCAT(DISTINCT a.nombre SEPARATOR ', ')
                 FROM perfiles_convocatoria pc
                 LEFT JOIN areas a ON pc.area_id = a.id
                 WHERE pc.convocatoria_id = c.id AND pc.activo = 1) as areas_nombres
                FROM {$this->table} c
                LEFT JOIN usuarios u ON c.usuario_id = u.id
                ORDER BY c.created_at DESC";
        return $this->query($sql);
    }

    public function getPublicadas() {
        $sql = "SELECT c.*,
                (SELECT COUNT(*) FROM perfiles_convocatoria WHERE convocatoria_id = c.id AND activo = 1) as total_perfiles
                FROM {$this->table} c
                WHERE c.estado = 'publicada'
                AND c.fecha_cierre >= CURDATE()
                ORDER BY c.fecha_inicio DESC";
        return $this->query($sql);
    }

    public function getById($id) {
        $sql = "SELECT c.*, u.nombre as usuario_nombre,
                (SELECT COUNT(*) FROM perfiles_convocatoria WHERE convocatoria_id = c.id) as total_perfiles
                FROM {$this->table} c
                LEFT JOIN usuarios u ON c.usuario_id = u.id
                WHERE c.id = :id LIMIT 1";
        $result = $this->query($sql, ['id' => $id]);
        return $result[0] ?? null;
    }

    public function getCarreras($convocatoriaId) {
        $sql = "SELECT c.* FROM carreras c
                INNER JOIN convocatoria_carreras cc ON c.id = cc.carrera_id
                WHERE cc.convocatoria_id = :id";
        return $this->query($sql, ['id' => $convocatoriaId]);
    }

    public function addCarrera($convocatoriaId, $carreraId) {
        $sql = "INSERT INTO convocatoria_carreras (convocatoria_id, carrera_id)
                VALUES (:convocatoria_id, :carrera_id)";
        return $this->execute($sql, [
            'convocatoria_id' => $convocatoriaId,
            'carrera_id' => $carreraId
        ]);
    }

    public function removeAllCarreras($convocatoriaId) {
        $sql = "DELETE FROM convocatoria_carreras WHERE convocatoria_id = :id";
        return $this->execute($sql, ['id' => $convocatoriaId]);
    }

    public function getPostulaciones($convocatoriaId) {
        $sql = "SELECT p.*,
                CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) as candidato_nombre,
                c.email as candidato_email,
                c.telefono as candidato_telefono,
                ca.nombre as carrera_nombre,
                pf.titulo as perfil_titulo
                FROM postulaciones p
                INNER JOIN candidatos c ON p.candidato_id = c.id
                LEFT JOIN carreras ca ON c.carrera_id = ca.id
                LEFT JOIN perfiles_convocatoria pf ON p.perfil_id = pf.id
                WHERE p.convocatoria_id = :id
                ORDER BY p.fecha_postulacion DESC";
        return $this->query($sql, ['id' => $convocatoriaId]);
    }

    public function getPerfiles($convocatoriaId) {
        require_once BASE_PATH . '/models/Perfil.php';
        $perfilModel = new Perfil();
        return $perfilModel->getByConvocatoria($convocatoriaId);
    }

    public function countPerfiles($convocatoriaId) {
        $sql = "SELECT COUNT(*) as total FROM perfiles_convocatoria WHERE convocatoria_id = :id AND activo = 1";
        $result = $this->query($sql, ['id' => $convocatoriaId]);
        return $result[0]['total'] ?? 0;
    }
}
