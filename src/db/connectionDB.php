<?php

namespace App\db;

use App\config\resposeHTTP;
use PDO;

// Asegúrate de que este archivo se incluya correctamente
require __DIR__ . '/dataDB.php';

class connectionDB {
    // Todas las propiedades deben ser estáticas porque se usan con self::
    private static $host;
    private static $user;
    private static $pass;

    // Método para inicializar las propiedades estáticas
    public static function inicializar($host, $user, $pass) {
        self::$host = $host;
        self::$user = $user;
        self::$pass = $pass;
    }

    // Método para obtener la conexión PDO
    public static function getConnection() {
        try {
            $opt = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];
            $pdo = new PDO(self::$host, self::$user, self::$pass, $opt);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            error_log("Conexión Exitosa");
            return $pdo;
        } catch (\PDOException $e) {
            error_log("Error en la conexión a la BD! ERROR: " . $e->getMessage());
            die(json_encode(resposeHTTP::status500()));
        }
    }
}