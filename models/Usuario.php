<?php
require_once BASE_PATH . '/core/Model.php';

class Usuario extends Model {
    protected $table = 'usuarios';

    public function authenticate($email, $password) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email AND activo = 1 LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function createUser($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->create($data);
    }
}
