<?php
require_once BASE_PATH . '/core/Model.php';

class UsuarioPostulante extends Model {
    protected $table = 'usuarios_postulantes';

    /**
     * Buscar usuario por DNI
     */
    public function findByDni($dni) {
        $sql = "SELECT * FROM {$this->table} WHERE dni = :dni LIMIT 1";
        $result = $this->query($sql, ['dni' => $dni]);
        return $result[0] ?? null;
    }

    /**
     * Buscar usuario por email
     */
    public function findByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
        $result = $this->query($sql, ['email' => $email]);
        return $result[0] ?? null;
    }

    /**
     * Verificar si un DNI ya está registrado
     */
    public function dniExists($dni) {
        return $this->findByDni($dni) !== null;
    }

    /**
     * Verificar si un email ya está registrado
     */
    public function emailExists($email) {
        return $this->findByEmail($email) !== null;
    }

    /**
     * Validar credenciales de login
     */
    public function validateLogin($dni, $password) {
        $usuario = $this->findByDni($dni);

        if (!$usuario) {
            return false;
        }

        if (!$usuario['activo']) {
            return false;
        }

        return password_verify($password, $usuario['password']) ? $usuario : false;
    }

    /**
     * Crear nuevo usuario postulante
     */
    public function createUsuario($data) {
        // Hash de contraseña
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        return $this->create($data);
    }

    /**
     * Actualizar último login
     */
    public function updateLastLogin($id) {
        $sql = "UPDATE {$this->table} SET updated_at = CURRENT_TIMESTAMP WHERE id = :id";
        return $this->execute($sql, ['id' => $id]);
    }
}
