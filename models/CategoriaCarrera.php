<?php
require_once BASE_PATH . '/core/Model.php';

class CategoriaCarrera extends Model {
    protected $table = 'categorias_carreras';

    public function getActive() {
        return $this->query("SELECT * FROM {$this->table} WHERE activo = 1 ORDER BY orden ASC, nombre ASC");
    }

    public function getAllOrdered() {
        return $this->query("SELECT * FROM {$this->table} ORDER BY orden ASC, nombre ASC");
    }

    public function getWithCarrerasCount() {
        $sql = "SELECT c.*,
                COUNT(car.id) as total_carreras
                FROM {$this->table} c
                LEFT JOIN carreras car ON c.id = car.categoria_id AND car.activo = 1
                GROUP BY c.id
                ORDER BY c.orden ASC, c.nombre ASC";
        return $this->query($sql);
    }
}
