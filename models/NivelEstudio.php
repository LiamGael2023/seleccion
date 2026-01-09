<?php
require_once BASE_PATH . '/core/Model.php';

class NivelEstudio extends Model {
    protected $table = 'niveles_estudio';

    public function getActive() {
        return $this->query("SELECT * FROM {$this->table} WHERE activo = 1 ORDER BY orden ASC, nombre ASC");
    }

    public function getAllOrdered() {
        return $this->query("SELECT * FROM {$this->table} ORDER BY orden ASC, nombre ASC");
    }

    public function getWithCarrerasCount() {
        $sql = "SELECT n.*,
                COUNT(c.id) as total_carreras
                FROM {$this->table} n
                LEFT JOIN carreras c ON n.id = c.nivel_id AND c.activo = 1
                GROUP BY n.id
                ORDER BY n.orden ASC, n.nombre ASC";
        return $this->query($sql);
    }
}
