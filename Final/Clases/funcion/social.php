<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-type: application/json');
header('Access-Control-Max-Age: 1000');
header("Access-Control-Allow-Credentials: true");
try {

    if ($verb == 'GET') {

        switch (strtolower($funcion)) {
            case "follows":
                $datos = $objeto->usuSeguido($id);
                $http->setHttpHeaders(200, new Response("Recomendacion", $datos));
                break;
            case "followers":
                $datos = $objeto->usuSeguidor($id);
                $http->setHttpHeaders(200, new Response("Recomendacion", $datos));
                break;
        }
    } else {
        
    }

    if ($verb == 'POST') {
        switch (strtolower($funcion)) {
            case "enviar":
                $json = json_decode(file_get_contents("php://input"), false);
                foreach ($json as $c => $v) {
                            $objeto->$c = $v;
                    }
                $objeto->save();
                $http->setHttpHeaders(200, new Response("Lista $controller", $objeto));
                break;
        }
    }
} catch (Exception $ex) {
    
}