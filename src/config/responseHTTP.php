<?php
//creamos un espacio de nombres 
//mas adelante lo configuraremos para que el autoload de composer pueda cargarlo de forma dinamica
namespace App\config;

class responseHTTP
{
    public static $mensaje = array(
        'status' => 'Error',
        'message' => 'No encontrado',
        'data' => ''
    );

    // Método modificado para aceptar cadenas o arreglos como respuesta
    final public static function status200($res)
    {
        http_response_code(200);
        self::$mensaje['status'] = 'OK';

        // Verificar si el parámetro es un arreglo o una cadena
        if (is_array($res)) {
            self::$mensaje = array_merge(self::$mensaje, $res);
        } else {
            self::$mensaje['message'] = $res;
        }

        return self::$mensaje;
    }

    final public static function status201()
    {
        $res = 'Recurso creado exitosamente!';
        http_response_code(201);
        self::$mensaje['status'] = 'OK';
        self::$mensaje['message'] = $res;
        return self::$mensaje;
    }

    final public static function status400($res = 'Formato de solicitud incorrecto!')
    {
        http_response_code(400);
        self::$mensaje['status'] = 'ERROR';
        self::$mensaje['message'] = $res;
        return self::$mensaje;
    }

    final public static function status401($res = 'No tiene privilegios para acceder al recurso!')
    {
        http_response_code(401);
        self::$mensaje['status'] = 'ERROR';
        self::$mensaje['message'] = $res;
        return self::$mensaje;
    }

    final public static function status404()
    {
        $res = 'No existe el recurso solicitado!';
        http_response_code(404);
        self::$mensaje['status'] = 'ERROR';
        self::$mensaje['message'] = $res;
        return self::$mensaje;
    }

    final public static function status500($res = 'Se ha producido un error en el servidor!')
    {
        http_response_code(500);
        self::$mensaje['status'] = 'ERROR';
        self::$mensaje['message'] = $res;
        return self::$mensaje;
    }

    public static function status405($message = 'Método no permitido') {
        return [
            'status' => 'ERROR',
            'message' => $message,
            'data' => null
        ];
    }
}