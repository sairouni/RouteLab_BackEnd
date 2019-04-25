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
            case "follow":
                $jsonRegistro = json_decode(file_get_contents("php://input"), false);
                $idseguido = $jsonRegistro->idseguido;
                $idseguidor = $jsonRegistro->idseguidor;
                    
                foreach ($jsonRegistro as $c => $v) {
                            $objeto->$c = $v;
                    }
                    
                    $objeto->save2();
                    $http->setHttpHeaders(200, new Response("Lista $controller",(String) $objeto));
                break;
        }
    }
    if ($verb == "DELETE") {
        switch (strtolower($funcion)) {
            case "unfollow":
                $jsonlogin = json_decode(file_get_contents("php://input"), false);
                $ids = $jsonlogin->idseguidor;
                $id = $jsonlogin->idseguido;
                $datos = $objeto->deleteSeguido($ids, $id);
                $http->setHttpHeaders(200, new Response("Datos eliminados", $datos));
                break;
        }
    }
} catch (Exception $ex) {
    
}