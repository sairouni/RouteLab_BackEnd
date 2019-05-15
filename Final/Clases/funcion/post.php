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
require_once '../recasociada.php';
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
                $datos = $objeto->postUsu($id);
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
                $jsonvalue = json_decode(json_decode(file_get_contents("php://input"), false));
                $titulo = $jsonvalue->post->titulo;
                $objeto->setTitulo($titulo);
                $descrip = $jsonvalue->post->descripcion;
                $objeto->setDescripcion($descrip);
                $categoria = $jsonvalue->post->categoria;
                $objeto->setCategoria($categoria);
                $duracion = $jsonvalue->post->duracion;
                $objeto->setDuracion($duracion);
                $distancia = $jsonvalue->post->distancia;
                $objeto->setDistancia($distancia);
                $objeto->setUsuario($userLogged);
                $objeto->save();
                $markers = $jsonvalue->post->markers;
                $localidad = new Localidad();
                foreach ($markers as $marker) {

                    foreach ($marker as $key => $value) {

                        $localidad->$key = $value;
                    }

                    $latitud = $localidad->latitud;
                    $longitud = $localidad->longitud;
                    $datos = $localidad->idexiste(['latitud' => $latitud, 'longitud' => $longitud]);
                    if ($datos == false) {
                        $localidad->save();
                    } else {
                        $localidad->load($datos);
                    }
                }

                $asociada = new Asociada();
                $asociada->setidLocalidad($localidad->idlocalidad);
                $asociada->setidPost($objeto->idpost);
                $asociada->save();
                $recaso = $jsonvalue->post->recs;
                foreach ($recaso as $rec) {
                    $recasociada = new RecAsociada();
                    $recasociada->setidRec($rec);
                    $recasociada->setidPost($objeto->idpost);
                    $recasociada->save();
                }
                $http->setHttpHeaders(200, new Response("Asociada insertado correctamente", $objeto->serialize()));
                break;

            case "foto":

                $files = $_FILES;

                if (isset($files["images"])) {
                    if ($files["images"] != "undefined") {
                        try {
                            $moved = false;
                            for ($i = 0; $i < count($files["images"]["tmp_name"]); $i++) {
                                // $ruta = $_SERVER['DOCUMENT_ROOT']."/assets/uploads/posts/$id/".$i.".jpg";

                                $path = $_SERVER['DOCUMENT_ROOT'] . "/assets/uploads/posts/$id/";


                                if (!is_dir($path)) {
                                    mkdir($path, 0777);
                                }

                                $ruta = $_SERVER['DOCUMENT_ROOT'] . "/assets/uploads/posts/$id/" . $i . ".jpg";

                                if (move_uploaded_file($files["images"]["tmp_name"][$i], $ruta)) {
                                    $moved = true;
                                } else {
                                    $moved = false;
                                }
                            }

                            if ($moved) {
                                $post = new Post();

                                $post->load($id);


                                $post->setNum_fotos(count($files["images"]["tmp_name"]));
                                $post->save();
                            }
                        } catch (Exception $e) {
                            $http->setHttpHeaders(200, new Response("Error on file $id " . $e->getMessage()));
                            die();
                        }
                    }
                }


                $http->setHTTPHeaders(201, new Response("Foto de Perfil Registrada correctamente", $datos));
                break;

            case "buscadorpost":
                $jsonRegistro = json_decode(file_get_contents("php://input"), false);
                $categoriavalor = $jsonRegistro->valor;
                $datos = $objeto->buscador_ruta($categoriavalor);
//               $datos = $objeto->loadAll();
//                for ($i = 0; $i < count($datos); $i++) {
//                    $datos[$i]['media'] = (string) $objeto->media($datos[$i]['idpost']);
//                }
                $http->setHttpHeaders(200, new Response("Lista $controller", $datos));


                break;


            case "buscadormedio":
                $jsonRegistro = json_decode(file_get_contents("php://input"), false);

                if (!isset($jsonRegistro->poblacion)) {
                    $categoria = $jsonRegistro->categoria;
                    $datos = $objeto->buscador_categoria($categoria);
                    $http->setHttpHeaders(200, new Response("Lista $controller", $datos));
                } elseif (!isset($jsonRegistro->categoria)) {
                    $ciudad = $jsonRegistro->poblacion;
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