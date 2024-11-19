<?php
use App\config\errorlogs;
use App\config\responseHTTP;

$allowedOrigins = [
    'http://localhost',
    'https://localhost',
    'http://127.0.0.1',
    'https://127.0.0.1'
];

// Verificar si el origen de la solicitud está permitido
if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins)) {
    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
    header('Access-Control-Allow-Credentials: true'); // Si necesitas credenciales
} else {
    http_response_code(403); // Prohibido
    exit('CORS error: Origin not allowed.');
}

// Manejo de solicitudes OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    http_response_code(200);
    exit;
}



require dirname(__DIR__).'/vendor/autoload.php';

errorlogs::activa_error_logs();
if(isset($_GET['route'])){
    $url = explode('/',$_GET['route']); 
    $lista = ['auth', 'user']; // lista de rutas permitidas
	$file = dirname(__DIR__).'/src/routes/'.$url[0].'.php';
    if(!in_array($url[0], $lista)){
        //LA ruta no existe
        echo json_encode(responseHTTP::status400());
        error_log('Esto es una prueba de un error');
        exit; //finalizamos la ejecución
    } 

    //validamos que el archivo exista y que es legible
    if(!file_exists($file) || !is_readable($file)){
        //El archivo no existe o no es legible
        echo json_encode(responseHTTP::status400());
    }else{
        require $file;
        exit;
    }

}else{
    //la variable GET route no esta definida
    echo json_encode(responseHTTP::status404());
}