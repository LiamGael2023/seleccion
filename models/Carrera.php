<?php
require_once BASE_PATH . '/core/Model.php';

class Carrera extends Model {
    protected $table = 'carreras';

    public function getActive() {
        return $this->where('activo', 1);
    }

    public function getByNivel($nivel) {
        return $this->where('nivel', $nivel);
    }

    public function getAllWithCategoria() {
        $sql = "SELECT c.*, cat.nombre as categoria_nombre
                FROM {$this->table} c
                LEFT JOIN categorias_carreras cat ON c.categoria_id = cat.id
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
