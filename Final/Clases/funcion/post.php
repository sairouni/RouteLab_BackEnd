<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-type: application/json');
header('Access-Control-Max-Age: 1000');
header("Access-Control-Allow-Credentials: true");
require_once '../asociada.php';
require_once '../post.php';

try {

    if ($verb == 'GET') {

        switch (strtolower($funcion)) {

            case"todo":
                if (empty($id)) {
                    $datos = $objeto->loadAll();
                    for ($i = 0; $i < count($datos); $i++) {
                        $datos[$i]['media'] = (string) $objeto->media($datos[$i]['idpost']);
                    }
                    $http->setHttpHeaders(200, new Response("Lista $controller", $datos));
                } else {
                    $objeto->load($id);
                    $http->setHttpHeaders(200, new Response("Lista $controller", (string) $objeto));
                }
                break;
            case "postbyid":
                $datos = $objeto->getbyIdPost($id);
                $datos2['media'] = $objeto->media($id);
                $datos3['markers'] = $objeto->markers($id);
                $final = (object) array_merge((array) $datos, (array) $datos2, (array) $datos3);
                $http->setHTTPHeaders(200, new Response("Lista Media Cantidad Estrellas", $final));
                //  $http->setHTTPHeaders(200, new Response("Post buscado",$datos2));
                //$http->setHTTPHeaders(200, new Response("Markers",$datos3));


                break;
            
                case "verusu":
                $idss = $userLogged->idusuario;
                $datos = $objeto->postUsu($idss);
                $http->setHttpHeaders(200, new Response("Todos los posts de este usuario", $datos));
                break;
            case "ver":
                $datos = $objeto->getbyIdPost($id);
                if ($datos == null) {

                    $http->setHTTPHeaders(200, new Response("Ese Post no existe:", $datos));
                } else {
                    $http->setHTTPHeaders(200, new Response("Datos:", $datos));
                }

                break;
        }
    } else {
        
    }

    if ($verb == 'POST') {
        switch (strtolower($funcion)) {
            case "post":
              $jsonRegistro = json_decode(file_get_contents("php://input"), false);
                $localidad = new Localidad();
                $pais = $jsonRegistro->localidad->pais;
                $poblacion = $jsonRegistro->localidad->poblacion;
                $direccion = $jsonRegistro->localidad->direccion;
                $latitud = $jsonRegistro->localidad->latitud;
                $longitud = $jsonRegistro->localidad->longitud;

                $datos = $localidad->idexiste(['latitud' => $latitud, 'longitud' => $longitud]);
                if ($datos == false) {
                    // Registrar localidad
                    foreach ($jsonRegistro->localidad as $c => $v) {
                        //$c=="idlocalidad"
                        $localidad->$c = $v;
                    }
                    $localidad->save();
                } else {

                    $localidad->load($datos);
                }
                    foreach ($jsonRegistro as $c => $v) {

                        if ($c != "localidad") {
                            $objeto->$c = $v;
                        } else {

                            $objeto->localidad = $localidad;
                        }
                    }
                    $objeto->save();

                    $http->setHttpHeaders(200, new Response("Lista $controller", (string) $objeto));
               




                break;

            case "foto":
               
                $file_post = $_FILES;
                $file_ary = array();
                $file_count = count($file_post['photo']);
                $file_keys = array_keys($file_post);

                for ($i = 0; $i < $file_count; $i++) {
                    foreach ($file_keys as $key) {
                        $file_ary[$i][$key] = $file_post[$key][$i];
                    }
                }
                return $file_ary;
        break;

        case "buscadorpost":
        $jsonRegistro = json_decode(file_get_contents("php://input"), false);
        $categoriavalor = $jsonRegistro->valor;
         $objeto->buscador_ruta($valor);
          $datos = $objeto->loadAll();
                    for ($i = 0; $i < count($datos); $i++) {
                        $datos[$i]['media'] = (string) $objeto->media($datos[$i]['idpost']);
                    }
                    $http->setHttpHeaders(200, new Response("Lista $controller", $datos));
 

        break;
    
    
            case "buscadormedio":
        $jsonRegistro = json_decode(file_get_contents("php://input"), false);
          
        if(!isset($jsonRegistro->poblacion )){
          $categoria= $jsonRegistro->categoria;       
        $datos = $objeto->buscador_categoria($categoria);
        $http->setHttpHeaders(200, new Response("Lista $controller", $datos));
            
        }elseif(!isset($jsonRegistro->categoria)){
        $ciudad= $jsonRegistro->poblacion; 
        $datos = $objeto->buscador_ciudad($ciudad);
        $http->setHttpHeaders(200, new Response("Lista $controller", $datos));
            
        } else {
            
        $datos = $objeto->buscador_categoria($categoria);
        $datos2 = $objeto->buscador_ciudad($ciudad);
        $resultado = array_merge($datos, $datos2);
        $http->setHttpHeaders(200, new Response("Lista $controller", $resultado));
        }
        
     

        break;


        case "buscador":
        $jsonRegistro = json_decode(file_get_contents("php://input"), false);
        $valor = $jsonRegistro->valor;
        $datos = $objeto->buscador_ruta($valor);
        $datos2 = $objeto->buscador_usu($valor);
        $resultado = array_merge($datos, $datos2);

        $http->setHttpHeaders(200, new Response("Lista $controller", $resultado));

        break;
    }
    }
} catch (Exception $ex) {
    
}