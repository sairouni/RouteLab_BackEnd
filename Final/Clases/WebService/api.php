<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-type: application/json');

require_once 'HTTP.php';
require_once 'Response.php';

$controller = filter_input(INPUT_GET, "controller");
$id = filter_input(INPUT_GET, "id");
$verb = $_SERVER['REQUEST_METHOD'];
$funcion = filter_input(INPUT_GET, 'funcion');
$http = new HTTP();

require_once '../'.$controller . '.php'; //require once lo que te pide el controller


if (empty($controller) || !file_exists('../'.$controller . ".php")) {
    $http = new HTTP();
    $http->setHttpHeaders(400, new Response("Bad request"));
    die();
}

$objeto = new $controller;


//verbo Get
if ($verb == "GET") {
    if (empty($id)) {
        $datos = $objeto->loadAll();
        $http->setHttpHeaders(200, new Response("Lista $controller", $datos));
    } else {
        $objeto->load($id);
        $http->setHttpHeaders(200, new Response("Lista $controller", $objeto->serialize()));
    }
}



// para añadir

if ($verb == "POST") {
    $raw = file_get_contents("php://input");
    $datos = json_decode($raw);
    foreach ($datos as $c => $v) {
        //$c=="idlocalidad"
        $objeto->$c = $v;
    }
    $objeto->save();
}

//para modificar xD
if ($verb == "PUT") {
    if (empty($id)) {
        $http->setHttpHeaders(400, new Response("Bad request"));
        die();
    }
    $objeto->load($id);
    $raw = file_get_contents("php://input");
    $datos = json_decode($raw);
    foreach ($datos as $c => $v) {
        $objeto->$c = $v;
    }
    $objeto->save();
}

//para eliminar
if ($verb == "DELETE") {
    if (empty($id)) {
        $http->setHttpHeaders(400, new Response("Bad request"));
        die();
    }
    $objeto->load($id);
    
    $objeto->delete();
}