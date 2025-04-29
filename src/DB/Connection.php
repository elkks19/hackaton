<?php

namespace App\DB;

use App\Config\Env;

class Connection {
    private static ?\PDO $pdo = null;

    private static function getDsn(): string {
        return Env::get('DATABASE_URL');
    }

    public static function init(): void {
        try {
            $dsn = self::getDsn(); // OJO: guardar en variable
            self::$pdo = new \PDO($dsn, Env::get('DB_USER'), Env::get('DB_PASSWORD'));
            self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit;
        }
    }

    public static function get(): \PDO {
        if (self::$pdo === null) {
            self::init();
        }

        return self::$pdo;
    }
}
?>
