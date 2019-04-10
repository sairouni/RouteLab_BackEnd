<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-type: application/json');
header('Access-Control-Max-Age: 1000');
header("Access-Control-Allow-Credentials: true");
require_once '../asociada.php';
try {

    if ($verb == 'GET') {

        switch (strtolower($funcion)) {
            case "postbyid":
                $datos = $objeto->getbyIdPost($id);
                $datos2['media'] = $objeto->media($id);
                $datos3['markers']= $objeto->markers($id);
                $final= (object) array_merge((array) $datos, (array) $datos2, (array) $datos3);
                $http->setHTTPHeaders(200, new Response("Lista Media Cantidad Estrellas", $final));
              //  $http->setHTTPHeaders(200, new Response("Post buscado",$datos2));
                //$http->setHTTPHeaders(200, new Response("Markers",$datos3));

               
                break;
           
        
            case "ver":
                $datos = $objeto->getbyIdPost($id);
                if($datos==null){
                    
                     $http->setHTTPHeaders(200, new Response("Ese Post no existe:",$datos));
                }else{
                     $http->setHTTPHeaders(200, new Response("Datos:",$datos));
                }
               
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