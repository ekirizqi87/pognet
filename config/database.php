<?php
/**
 * Koneksi Database PDO — GNetindo
 */

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        try {
            $port = defined('DB_PORT') ? DB_PORT : 3306;
            $dsn = "mysql:host=" . DB_HOST . ";port=" . $port . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::ATTR_TIMEOUT            => 10,
                PDO::ATTR_PERSISTENT         => false,
            ];
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            error_log("DB Connection failed: " . $e->getMessage());
            if (APP_DEBUG) {
                die("Koneksi database gagal: " . $e->getMessage());
            }
            die("Koneksi database gagal. Silakan hubungi administrator.");
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function pdo() {
        return $this->pdo;
    }
}

function db() {
    return Database::getInstance()->pdo();
}