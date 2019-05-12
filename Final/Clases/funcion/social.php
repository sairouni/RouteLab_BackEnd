<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-type: application/json');
header('Access-Control-Max-Age: 1000');
header("Access-Control-Allow-Credentials: true");
require_once '../usuario.php';
try {

    if ($verb == 'GET') {

        switch (strtolower($funcion)) {
            case "follows":
                $datos = $objeto->usuSeguido($id);
                $http->setHttpHeaders(200, new Response("Follows", $datos));
                break;
            case "followers":
                $datos = $objeto->usuSeguidor($id);
                $http->setHttpHeaders(200, new Response("Followers", $datos));
                break;
        }
    } else {
        
    }

    if ($verb == 'POST') {
        switch (strtolower($funcion)) {
            case "follow":
                $jsonRegistro = json_decode(file_get_contents("php://input"), false);
                $idseguido = $jsonRegistro->idseguido;
                $idseguidor = $jsonRegistro->idseguidor;

                foreach ($jsonRegistro as $c => $v) {
                    $objeto->$c = $v;
                }

                $objeto->save2();
                $http->setHttpHeaders(200, new Response("Lista $controller", (String) $objeto));
                break;
            case "ff":
                $jsonRegistro = json_decode(file_get_contents("php://input"), false);
                $idseguido = $jsonRegistro->idseguido;
                $idseguidor = $jsonRegistro->idseguidor;
                $datos = $objeto->usuSeguidoY($idseguido, $idseguidor);
                $http->setHttpHeaders(200, new Response("Seguidos/res", (String) $datos));
                break;
            case "unfollow":
                $jsonlogin = json_decode(file_get_contents("php://input"), false);
                $idseguidor = $jsonlogin->idseguidor;
                $idseguido = $jsonlogin->idseguido;
                $datos = $objeto->deleteSeguido($idseguidor, $idseguido);
                $http->setHttpHeaders(200, new Response("Datos eliminados", $datos));
                break;
        }
    }
    if ($verb == "DELETE") {
        switch (strtolower($funcion)) {
            
        }
    }
} catch (Exception $ex) {
    
}
