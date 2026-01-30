<?php
/**
 * Clase de conexión a base de datos - SQL Server
 * Esta clase soporta conexiones a Microsoft SQL Server usando PDO
 */
class DatabaseSQLServer {
    private static $instance = null;
    private $connection;
    private $driver;

    private function __construct() {
        $config = require BASE_PATH . '/config/database.php';

        // Determinar el driver a usar (por defecto mysql)
        $this->driver = $config['driver'] ?? 'mysql';

        try {
            if ($this->driver === 'sqlsrv') {
                // Conexión SQL Server
                $dsn = "sqlsrv:Server={$config['host']}";

                if (isset($config['port'])) {
                    $dsn .= ",{$config['port']}";
                }

                $dsn .= ";Database={$config['database']}";

                $options = $config['options'] ?? [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::SQLSRV_ATTR_ENCODING => PDO::SQLSRV_ENCODING_UTF8
                ];

                $this->connection = new PDO($dsn, $config['username'], $config['password'], $options);

            } else {
                // Conexión MySQL (por defecto)
                $dsn = "mysql:host={$config['host']}";

                if (isset($config['port'])) {
                    $dsn .= ";port={$config['port']}";
                }

                $dsn .= ";dbname={$config['database']};charset={$config['charset']}";

                $this->connection = new PDO($dsn, $config['username'], $config['password']);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            }

        } catch (PDOException $e) {
            die("Error de conexión a la base de datos ({$this->driver}): " . $e->getMessage());
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

    public function getDriver() {
        return $this->driver;
    }

    /**
     * Obtener el ID del último registro insertado
     * SQL Server usa SCOPE_IDENTITY() en lugar de LAST_INSERT_ID()
     */
    public function lastInsertId($name = null) {
        if ($this->driver === 'sqlsrv') {
            $stmt = $this->connection->query("SELECT SCOPE_IDENTITY() as id");
            $result = $stmt->fetch();
            return $result['id'] ?? null;
        } else {
            return $this->connection->lastInsertId($name);
        }
    }

    private function __clone() {}

    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}
