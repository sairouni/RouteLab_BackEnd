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
            case "media":
                $jsonlogin = json_decode(file_get_contents("php://input"), false);
                $id = $jsonlogin->idpost;
                
                $datos2 = $objeto->getbyIdPost($id);
                $datos = $objeto->media($id);
                $http->setHTTPHeaders(200, new Response("Lista Media Cantidad Estrellas", $datos));
                $http->setHTTPHeaders(200, new Response("Post buscado", $datos2));
                break;
            case "postid":
                $datos = $objeto->getbyIdPost($id);
                $http->setHTTPHeaders(200, new Response("Datos:", $datos));
                break;
        }
    } else {
        
    }

    if ($verb == 'POST') {
        switch (strtolower($funcion)) {
            case "Post":
                $objeto = savePost($json);
                break;
        }
    }
} catch (Exception $ex) {
    
}