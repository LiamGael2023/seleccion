<?php
require_once BASE_PATH . '/core/Model.php';

class Carrera extends Model {
    protected $table = 'carreras';

    public function getActive() {
        $sql = "SELECT c.*,
                cat.nombre as categoria_nombre,
                n.nombre as nivel_nombre
                FROM {$this->table} c
                LEFT JOIN categorias_carreras cat ON c.categoria_id = cat.id
                LEFT JOIN niveles_estudio n ON c.nivel_id = n.id
                WHERE c.activo = 1
                ORDER BY cat.orden ASC, cat.nombre ASC, c.nombre ASC";
        return $this->query($sql);
    }

    public function getByNivel($nivelId) {
        return $this->where('nivel_id', $nivelId);
    }

    public function getAllWithCategoria() {
        $sql = "SELECT c.*,
                cat.nombre as categoria_nombre,
                n.nombre as nivel_nombre
                FROM {$this->table} c
                LEFT JOIN categorias_carreras cat ON c.categoria_id = cat.id
                LEFT JOIN niveles_estudio n ON c.nivel_id = n.id
                ORDER BY cat.orden ASC, cat.nombre ASC, c.nombre ASC";
        return $this->query($sql);
    }

    public function getActiveGroupedByCategoria() {
        $sql = "SELECT c.*, cat.nombre as categoria_nombre, cat.id as categoria_id
                FROM {$this->table} c
                LEFT JOIN categorias_carreras cat ON c.categoria_id = cat.id
                WHERE c.activo = 1
                ORDER BY cat.orden ASC, cat.nombre ASC, c.nombre ASC";

        $carreras = $this->query($sql);

        // Agrupar por categoría
        $grouped = [];
        foreach ($carreras as $carrera) {
            $categoriaId = $carrera['categoria_id'] ?? 'sin_categoria';
            $categoriaNombre = $carrera['categoria_nombre'] ?? 'Sin Categoría';

            if (!isset($grouped[$categoriaId])) {
                $grouped[$categoriaId] = [
                    'categoria_id' => $categoriaId,
                    'categoria_nombre' => $categoriaNombre,
                    'carreras' => []
                ];
            }

            $grouped[$categoriaId]['carreras'][] = $carrera;
        }

        return array_values($grouped);
    }

    public function getByCategoria($categoriaId) {
        return $this->where('categoria_id', $categoriaId);
    }
}
