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
            
            case "foto":
             
                $files = $_FILES;
               for($u=0;$u<5;$u++){       
               if (isset($files["photo".$u])) {
                    if ($files["photo".$u]!= "undefined") { 
                        try { 
                            $ruta = "C:/Users/isma_/Desktop/$controller" . "s/" . $u . ".jpg";
                            //$ruta = "C:/Users/isma_/Desktop/$controller" . "s/".$objeto->$nombreusu.".jpg";
                            
                            move_uploaded_file($files["photo".$u]["tmp_name"], $ruta);       
                        } catch (Exception $e) {
                            $http->setHttpHeaders(200, new Response("Bad request Error No User With This Token"));
                            die();
                        }
                    }
                        //$ruta = "/assets/uploads/$controller" . "s/" .$nombreusu. ".jpg";
                    }
                }
                $http->setHTTPHeaders(201, new Response("Foto Registrada correctamente"));

                break;
                
                
                
                break;
                
                case "buscadorpost":
                $jsonRegistro = json_decode(file_get_contents("php://input"), false);
                $valor = $jsonRegistro->valor;
                $datos = $objeto->buscador_ruta($valor);
                $http->setHttpHeaders(200, new Response("Lista $controller",$datos));

                break;
            
            
            case "buscador":
                $jsonRegistro = json_decode(file_get_contents("php://input"), false);
                $valor = $jsonRegistro->valor;
                $datos = $objeto->buscador_ruta($valor);
                $datos2 = $objeto->buscador_usu($valor);
                $resultado = array_merge($datos, $datos2);
                
                $http->setHttpHeaders(200, new Response("Lista $controller",$resultado));

                break;
        }
    }
} catch (Exception $ex) {
    
}