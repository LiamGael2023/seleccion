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
}
