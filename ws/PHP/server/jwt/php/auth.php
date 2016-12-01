<?php
include_once '../vendor/autoload.php';
require '../../../clases/Usuario.php';
use \Firebase\JWT\JWT;

$DatosPorPost = file_get_contents("php://input");
$respuesta = json_decode($DatosPorPost);

if (Usuario::ValidarUsuario($respuesta->usuario, $respuesta->clave, $respuesta->dni)) {
    $payload = array(
        'exp' => time() + 600,
        'username' => $respuesta->usuario
    );

    $key = "123456";

    /**
    * IMPORTANT:
    * You must specify supported algorithms for your application. See
    * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
    * for a list of spec-compliant algorithms.
    */
    $jwt = JWT::encode($payload, $key);
    $myArray["myToken"] = $jwt;
    $myArray["username"] = $respuesta->usuario;
    echo json_encode($myArray);    
} else {
    $myArray["myToken"] = false;
    echo json_encode($myArray);
}



?>