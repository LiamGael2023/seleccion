<?php
require_once BASE_PATH . '/core/Model.php';

class Area extends Model {
    protected $table = 'areas';

    public function getActive() {
        return $this->where('activo', 1);
    }
}
