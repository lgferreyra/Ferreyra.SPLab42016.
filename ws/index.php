<?php

/**
 * Step 1: Require the Slim Framework using Composer's autoloader
 *
 * If you are not using Composer, you need to load Slim Framework with your own
 * PSR-4 autoloader.
 */
require 'PHP/clases/Votacion.php';
require 'PHP/clases/Usuario.php';
require 'vendor/autoload.php';

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$c = new \Slim\Container($configuration);
$app = new \Slim\App($c);

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */
/**
* GET: Para consultar y leer recursos
* POST: Para crear recursos
* PUT: Para editar recursos
* DELETE: Para eliminar recursos
*
*  GET: Para consultar y leer recursos */

$app->get('/', function ($request, $response, $args) {
    $response->write("Welcome to Slim!");
    return $response;
});

$app->get('/usuarios[/]', function ($request, $response, $args) {
    $respuesta=Usuario::TraerTodosLosUsuarios();
    $arrayJson = json_encode($respuesta);
    $response->write($arrayJson);
    return $response;
});

$app->get('/usuario[/{id}[/{name}]]', function ($request, $response, $args) {
    $response->write("Datos usuario ");
    var_dump($args);
    return $response;
});
/* POST: Para crear recursos */
$app->post('/usuario[/{usuario}]', function ($request, $response, $args) {
    $parsedBody = $request->getParsedBody();
    $idInserted = Usuario::InsertarUsuario($parsedBody);

    $response->write($idInserted);

    return $response;
});

// /* PUT: Para editar recursos */
$app->put('/usuario/{id}', function ($request, $response, $args) {
    $response->write("Welcome to Slim!");
    var_dump($args);
    var_dump($response);
    var_dump($request);
    return $response;
});

// /* DELETE: Para eliminar recursos */
$app->delete('/usuario/{id}', function ($request, $response, $args) {
    $response->write("borrar !", $args->id);
    var_dump($args);
    return $response;
});



//*VOTACIONES*

// GET: traer todas las personas
$app->get('/votaciones[/]', function ($request, $response, $args) {
    $respuesta= array();
    $respuesta=Votacion::TraerTodas();
    $arrayJson = json_encode($respuesta);
    $response->write($arrayJson);
    return $response;
});

// GET: traer una votacion
$app->get('/votacion[/{id}]', function ($request, $response, $args) {
    $respuesta = Votacion::TraerUna($args['id']);
    $personaJson = json_encode($respuesta);
    $response->write($personaJson);
    return $response;
});

//POST: crear una votacion
$app->post('/votacion/crear[/]', function ($request, $response, $args) {
    $parsedBody = $request->getParsedBody();
    $idInserted = Votacion::Insertar($parsedBody);
    $response->write($idInserted);
    return $response;
});

//PUT: Para editar una votacion
$app->put('/votacion[/]', function ($request, $response, $args) {
    $parsedBody = $request->getParsedBody();
    Votacion::Modificar($parsedBody);
    $response->write("Votacion modificada");
    return $response;
});

// /* DELETE: Para eliminar recursos */
$app->delete('/votacion[/{id}]', function ($request, $response, $args) {
    $respuesta = Votacion::Borrar($args['id']);
    $response->write($respuesta);
    return $response;
});

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
