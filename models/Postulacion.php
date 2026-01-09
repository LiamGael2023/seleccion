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

    /**
     * Verificar si un usuario postulante ya se postuló a algún perfil de una convocatoria
     * Retorna false si no tiene postulación, o un array con los datos de la postulación existente
     */
    public function tienePostulacionEnConvocatoria($convocatoriaId, $usuarioPostulanteId) {
        $sql = "SELECT p.*, pf.titulo as perfil_titulo
                FROM {$this->table} p
                INNER JOIN candidatos c ON p.candidato_id = c.id
                INNER JOIN perfiles_convocatoria pf ON p.perfil_id = pf.id
                WHERE p.convocatoria_id = :convocatoria_id
                AND c.usuario_postulante_id = :usuario_postulante_id
                LIMIT 1";
        $result = $this->query($sql, [
            'convocatoria_id' => $convocatoriaId,
            'usuario_postulante_id' => $usuarioPostulanteId
        ]);
        return $result[0] ?? false;
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
