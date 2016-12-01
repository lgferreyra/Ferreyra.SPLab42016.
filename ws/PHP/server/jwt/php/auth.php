<?php
include_once '../vendor/autoload.php';
require '../../../clases/Usuarios.php';
use \Firebase\JWT\JWT;

$DatosPorPost = file_get_contents("php://input");
$respuesta = json_decode($DatosPorPost);

if (Usuario::ValidarUsuario($respuesta->usuario, $respuesta->clave, $respuesta->dni)) {
    $token["exp"] = time() + 30;
    $token["message"] = "userRegister";
    $key = "123456";

    /**
    * IMPORTANT:
    * You must specify supported algorithms for your application. See
    * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
    * for a list of spec-compliant algorithms.
    */
    $jwt = JWT::encode($token, $key);
    $myArray["myToken"] = $jwt;
    echo json_encode($myArray);    
} else {
    $myArray["myToken"] = false;
    echo json_encode($myArray);
}



?>