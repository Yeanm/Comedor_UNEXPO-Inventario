<?php
class Conexion {
    private static $pdo = null;

    public static function conectar() {
        if (self::$pdo === null) {
            $host = 'localhost';
            $db   = 'inventario_db';
            $user = 'root';
            $pass = '';

            $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

            try {
                self::$pdo = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
