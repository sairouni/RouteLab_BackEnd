<?php

try {

    if ($verb == 'GET') {

        switch (strtolower($funcion)) {
             case "media":
              $jsonlogin = json_decode(file_get_contents("php://input"), false);
                $id = $jsonlogin->idpost;
                 
                 $datos = $objeto->media($id);
                $http->setHTTPHeaders(200, new Response("Lista Media Cantidad Estrellas", $datos));
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