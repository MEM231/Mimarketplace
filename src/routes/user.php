<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Obtener datos del usuario autenticado
$app->get('/user-data', function ($request, $response, $args) {
    // Cabeceras de CORS
    $response = $response->withHeader("Access-Control-Allow-Origin", "*")
                         ->withHeader("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS")
                         ->withHeader("Access-Control-Allow-Headers", "Content-Type, Authorization");

    require_once __DIR__ . '/../src/config/connectionDB.php';
    require_once __DIR__ . '/../src/config/Security.php';

    $headers = $request->getHeaders();
    $authHeader = $headers['Authorization'][0] ?? null;

    if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
        return $response->withStatus(401)->withJson(["error" => "Token no proporcionado o inválido."]);
    }

    $token = str_replace('Bearer ', '', $authHeader);
    $key = $_ENV['JWT_SECRET']; // Asegúrate de que tu clave secreta esté en el archivo .env

    try {
        // Decodificar el token
        $decoded = JWT::decode($token, new Key($key, 'HS256'));
        $userEmail = $decoded->correo; // Supongamos que el email está en el token

        // Conexión a la base de datos
        $conn = new PDO($dsn, $username, $password);
        $stmt = $conn->prepare("SELECT nombre, correo, tipo FROM usuarios WHERE correo = :correo");
        $stmt->bindParam(':correo', $userEmail);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return $response->withStatus(404)->withJson(["error" => "Usuario no encontrado."]);
        }

        // Respuesta exitosa
        return $response->withJson($user);

    } catch (Exception $e) {
        return $response->withStatus(401)->withJson(["error" => "Error de autenticación: " . $e->getMessage()]);
    }
});