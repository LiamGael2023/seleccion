<?php
require_once BASE_PATH . '/core/Model.php';

class Area extends Model {
    protected $table = 'areas';

    public function getActive() {
        return $this->where('activo', 1);
    }

    public function getAllWithHierarchy() {
        $sql = "SELECT a.*,
                ap.nombre as area_padre_nombre,
                COALESCE(ap.nombre, a.nombre) as orden_grupo
                FROM {$this->table} a
                LEFT JOIN {$this->table} ap ON a.area_padre_id = ap.id
                ORDER BY orden_grupo ASC, a.area_padre_id IS NULL DESC, a.nombre ASC";
        return $this->query($sql);
    }

    public function getAreasPadre() {
        $sql = "SELECT * FROM {$this->table}
                WHERE area_padre_id IS NULL
                AND activo = 1
                ORDER BY nombre ASC";
        return $this->query($sql);
    }

    public function getAreasHijas($areaPadreId) {
        return $this->where('area_padre_id', $areaPadreId);
    }

    public function getTreeStructure() {
        $sql = "SELECT * FROM {$this->table} ORDER BY area_padre_id ASC, nombre ASC";
        $areas = $this->query($sql);

        $tree = [];
        foreach ($areas as $area) {
            if ($area['area_padre_id'] === null) {
                $area['hijas'] = [];
                $tree[$area['id']] = $area;
            }
        }

        foreach ($areas as $area) {
            if ($area['area_padre_id'] !== null && isset($tree[$area['area_padre_id']])) {
                $tree[$area['area_padre_id']]['hijas'][] = $area;
            }
        }

        return array_values($tree);
    }
}
