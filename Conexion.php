<?php
class Conexion {
    public static function conectar() {
        $pdo = new PDO(
            "mysql:host=localhost;dbname=frutas_encremadas_pro;charset=utf8mb4",
            "root",
            ""
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}
