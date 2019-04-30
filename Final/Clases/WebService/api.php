<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-type: application/json');
header('Access-Control-Max-Age: 1000');
header("Access-Control-Allow-Credentials: true");
require_once 'http.php';

require_once 'response.php';

$controller = filter_input(INPUT_GET, "controller");
$id = filter_input(INPUT_GET, "id");
$nombreusuario = filter_input(INPUT_GET, "nombreusuario");
$verb = $_SERVER['REQUEST_METHOD'];
$funcion = filter_input(INPUT_GET, 'funcion');
$http = new HTTP();

require_once '../' . $controller . '.php'; //require once lo que te pide el controller
$objeto = new $controller;

if (empty($funcion)) {

    if (empty($controller) || !file_exists('../' . $controller . ".php")) {
        $http = new HTTP();
        $http->setHttpHeaders(400, new Response("Bad request"));
        die();
    }





//if ($function != "login" && $function != "registro") {
//        //Miramos si el Token esta bien del usuario logeado
//        try {
//            $userLogged = new usuario();
//            $userLogged->getByToken($token);
//        } catch (Exception $e) {
//            $http->setHttpHeaders(200, new Response("Bad request Error No User With This Token"));
//            die();
//           
//        }
//    }
//verbo Get
    if ($verb == "GET") {
        if (empty($id)) {
            $datos = $objeto->loadAll();
            $http->setHttpHeaders(200, new Response("Lista $controller", $datos));
        } else {
            $objeto->load($id);
            $http->setHttpHeaders(200, new Response("Lista $controller", (string) $objeto));
        }
    }

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
} else {

    require_once '../funcion/' . strtolower($controller) . '.php';
}
