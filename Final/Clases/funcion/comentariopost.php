<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-type: application/json');
header('Access-Control-Max-Age: 1000');
header("Access-Control-Allow-Credentials: true");
require_once '../usuario.php';
require_once '../post.php';
try {

    if ($verb == 'POST') {

        switch (strtolower($funcion)) {
            case "comentario":
                $jsonComentario = json_decode(file_get_contents("php://input"), false);
                $comentario = $jsonComentario->comentario;
                $post = new Post($jsonComentario->idpost);
                $usuario = new usuario($jsonComentario->idusuario);
                if (!empty($comentario)) {
                    foreach ($jsonComentario as $c => $v) {
                        $objeto->$c = $v;
                    }
                    $objeto->save();
                    $http->setHTTPHeaders(200, new Response("Comentario insertado exitosamente", $datos));
                } else {
                    $http->setHTTPHeaders(200, new Response("Comentario vacío",(String) $datos));
                }
                break;
        }
    }
    if ($verb == 'GET'){
        switch (strtolower($funcion)) {
        case "comenpost":


                $datos = $objeto->getbyPostC($id);
                $http->setHttpHeaders(200, new Response("Recomendacion", $datos));
                break;
        }
    }
    else {
        
    }
//
//    if ($verb == 'POST') {
//        switch (strtolower($funcion)) {
//                case "Post":
//                $objeto = savePost($json);
//                break;
//        }
//            
//    }
} catch (Exception $ex) {
    
}