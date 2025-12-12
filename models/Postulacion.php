<?php
require_once BASE_PATH . '/core/Model.php';

class Postulacion extends Model {
    protected $table = 'postulaciones';

    public function existePostulacion($convocatoriaId, $candidatoId) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}
                WHERE convocatoria_id = :convocatoria_id
                AND candidato_id = :candidato_id";
        $result = $this->query($sql, [
            'convocatoria_id' => $convocatoriaId,
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
}
