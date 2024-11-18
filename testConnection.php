<?php

require 'vendor/autoload.php'; // Asegúrate de que los autoloaders estén cargados
use App\db\connectionDB;

try {
    // Intenta obtener la conexión
    $pdo = connectionDB::getConnection();
    echo "Conexión exitosa!";
} catch (Exception $e) {
    echo "Error en la conexión: " . $e->getMessage();
}