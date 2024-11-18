<?php
use App\db\connectionDB;
use App\config\responseHTTP;
use App\config\Security;

$data = json_decode(file_get_contents("php://input"), true);

// Validamos que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($data['accion']) && $data['accion'] === 'registro') {
        // Lógica de registro (sin cambios)
        if (!isset($data['nombre'], $data['correo'], $data['contrasena'], $data['tipo'])) {
            echo json_encode(responseHTTP::status400("Todos los campos son requeridos para el registro."));
            exit;
        }

        $nombre = $data['nombre'];
        $correo = $data['correo'];
        $contrasena = Security::createPassword($data['contrasena']);
        $tipo = $data['tipo'];

        if (!in_array($tipo, ['vendedor', 'comprador'])) {
            echo json_encode(responseHTTP::status400("El tipo de usuario debe ser 'vendedor' o 'comprador'."));
            exit;
        }

        try {
            $pdo = connectionDB::getConnection();
            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, contrasena, tipo) VALUES (:nombre, :correo, :contrasena, :tipo)");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':contrasena', $contrasena);
            $stmt->bindParam(':tipo', $tipo);

            if ($stmt->execute()) {
                echo json_encode(responseHTTP::status200("Usuario registrado con éxito."));
            } else {
                echo json_encode(responseHTTP::status500("Error al registrar usuario."));
            }
        } catch (PDOException $e) {
            echo json_encode(responseHTTP::status500("Error en la base de datos: " . $e->getMessage()));
        }
    } elseif (isset($data['accion']) && $data['accion'] === 'login') {
        // Lógica de inicio de sesión
        if (!isset($data['correo'], $data['contrasena'])) {
            echo json_encode(responseHTTP::status400("Correo y contraseña son requeridos para iniciar sesión."));
            exit;
        }

        $correo = $data['correo'];
        $contrasena = $data['contrasena'];

        try {
            $pdo = connectionDB::getConnection();
            $stmt = $pdo->prepare("SELECT id, nombre, contrasena, tipo FROM usuarios WHERE correo = :correo");
            $stmt->bindParam(':correo', $correo);
            $stmt->execute();

            $usuario = $stmt->fetch();

            if ($usuario && Security::validatePassword($contrasena, $usuario['contrasena'])) {
                // Generar el token JWT
                $token = Security::createTokenJwt(
                    Security::secretKey(),
                    [
                        'id' => $usuario['id'],
                        'nombre' => $usuario['nombre'],
                        'tipo' => $usuario['tipo']
                    ]
                );

                // Responder con el token
                echo json_encode(responseHTTP::status200([
                    'message' => "Inicio de sesión exitoso.",
                    'token' => $token
                ]));
            } else {
                echo json_encode(responseHTTP::status401("Correo o contraseña incorrectos."));
            }
        } catch (PDOException $e) {
            echo json_encode(responseHTTP::status500("Error en la base de datos: " . $e->getMessage()));
        }
    } else {
        echo json_encode(responseHTTP::status400("Acción no especificada o inválida."));
    }
} else {
    echo json_encode(responseHTTP::status405("Método no permitido."));
}