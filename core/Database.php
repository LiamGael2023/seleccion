<?php
/**
 * Clase de conexión a base de datos
 */
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $config = require BASE_PATH . '/config/database.php';

        try {
            $dsn = "mysql:host={$config['host']}";
            if (isset($config['port'])) {
                $dsn .= ";port={$config['port']}";
            }
            $dsn .= ";dbname={$config['database']};charset={$config['charset']}";

            $this->connection = new PDO($dsn, $config['username'], $config['password']);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    private function __clone() {}

    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}
