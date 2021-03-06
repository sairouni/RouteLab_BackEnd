<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-type: application/json');
header('Access-Control-Max-Age: 1000');
header("Access-Control-Allow-Credentials: true");
require_once '../localidad.php';


try {

    if ($verb == 'GET') {

        switch (strtolower($funcion)) {

            case "media":
                $jsonlogin = json_decode(file_get_contents("php://input"), false);
                $id = $userLogged->idusuario;
                $datos = $objeto->media($id);
                $http->setHTTPHeaders(200, new Response("Lista Media Cantidad Estrellas", (string) $datos));
                break;
            case "loadusu":
                $datos = $objeto->getbyToken($token);
                $id = $objeto->idusuario;
                $datos = $objeto->verUsu($id);
                $http->setHTTPHeaders(200, new Response("Datos:",$datos));
           
                break;
            case "ver":
                $id = $userLogged->idusuario;
                $datos = $objeto->getById($id);
                $http->setHttpHeaders(200, new Response("Lista $controller", $datos));
                break;
            case "verusuario":
                $datos = $objeto->verUsu($id);
                $http->setHttpHeaders(200, new Response("Lista $controller", $datos));
                break;
        }
    } else {
        
    }

    if ($verb == 'PUT') {
        // Pasar el id a la funcion "edit", si no se le pasa id devolvera una respuesta incorrecta
        switch (strtolower($funcion)) {
            case "edit":
                $id = $userLogged->idusuario;
                $objeto->load($id);
                if (empty($id)) {
                    $http->setHttpHeaders(400, new Response("Bad request"));
                    die();
                }
                $jsonRegistro = json_decode(file_get_contents("php://input"), false);
                $email = $jsonRegistro->email;
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


                if ($objeto->idexiste(['email' => $email]) == $id) {
                    foreach ($jsonRegistro as $c => $v) {
                        if ($c != "localidad") {
                            $objeto->$c = $v;
                        } else {

                            $objeto->localidad = $localidad;
                        }
                    }
                    $objeto->save();

                    $http->setHttpHeaders(200, new Response("Lista $controller", $objeto));
                    $http->setHttpHeaders(600, new Response("El $controller con el email $email es tuyo", $email));
                } else if ($objeto->existe(['email' => $email])) {
                    $http->setHttpHeaders(600, new Response("El $controller con el email $email esta registrado", $email));
                } else {
                    foreach ($jsonRegistro as $c => $v) {
                        if ($c != "localidad") {
                            $objeto->$c = $v;
                        } else {

                            $objeto->localidad = $localidad;
                        }
                    }
                    $objeto->save();
                    $http->setHttpHeaders(200, new Response("Lista $controller", (string) $objeto));
                }
                break;
        }
    } else {
        
    }
    if ($verb == 'POST') {
        switch (strtolower($funcion)) {
            case "buscadorusu":
                $jsonRegistro = json_decode(file_get_contents("php://input"), false);
                $nombreusuario = $jsonRegistro->nombreusuario;
                $datos = $objeto->buscador_usu($nombreusuario);
                $http->setHttpHeaders(200, new Response("Lista $controller", $datos));

                break;
            case "edit":
                $id = $userLogged->idusuario;
                $objeto->load($id);
                if (empty($id)) {
                    $http->setHttpHeaders(400, new Response("Bad request"));
                    die();
                }
                $jsonRegistro = json_decode(file_get_contents("php://input"), false);
                $email = $jsonRegistro->email;
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


                if ($objeto->idexiste(['email' => $email]) == $id) {
                    foreach ($jsonRegistro as $c => $v) {
                        if ($c != "localidad") {
                            $objeto->$c = $v;
                        } else {

                            $objeto->localidad = $localidad;
                        }
                    }
                    $objeto->save();

                    $http->setHttpHeaders(200, new Response("Lista $controller", $objeto));
                    $http->setHttpHeaders(600, new Response("El $controller con el email $email es tuyo", $email));
                } else if ($objeto->existe(['email' => $email])) {
                    $http->setHttpHeaders(600, new Response("El $controller con el email $email esta registrado", $email));
                } else {
                    foreach ($jsonRegistro as $c => $v) {
                        if ($c != "localidad") {
                            $objeto->$c = $v;
                        } else {

                            $objeto->localidad = $localidad;
                        }
                    }
                    $objeto->save();
                    $http->setHttpHeaders(200, new Response("Lista $controller", (string) $objeto));
                }
                break;


            case "fotoperfil":
                //  $body = file_get_contents('php://input');
                $files = $_FILES;
                if (isset($files["photo"])) {

                    if ($files["photo"] != "undefined") {
                        try {
                            $nombreusu = $userLogged->nombreusuario;
                            $ruta = $_SERVER['DOCUMENT_ROOT'] . "/assets/uploads/usuarios/" . $nombreusu . ".jpg";
                            move_uploaded_file($files["photo"]["tmp_name"], $ruta);
                        } catch (Exception $e) {
                            $http->setHttpHeaders(200, new Response("Bad request Error No User With This Token"));
                            die();
                        }
                    }
                }
                $datos = $userLogged->nombreusuario;
                $http->setHTTPHeaders(201, new Response("Foto de Perfil Registrada correctamente", $datos));

                break;

            case "fotoback":
                //  $body = file_get_contents('php://input');
                $files = $_FILES;
                if (isset($files["photo"])) {

                    if ($files["photo"] != "undefined") {
                        try {
                            $nombreusu = $userLogged->nombreusuario;
                            $ruta = $_SERVER['DOCUMENT_ROOT'] . "/assets/uploads/background/" . $nombreusu . ".jpg";
                            move_uploaded_file($files["photo"]["tmp_name"], $ruta);
                        } catch (Exception $e) {
                            $http->setHttpHeaders(200, new Response("Bad request Error No User With This Token"));
                            die();
                        }
                    }
                }
                $datos = $userLogged->nombreusuario;
                $http->setHTTPHeaders(201, new Response("Foto background registrado", $datos));

                break;

            case "registro":
                $jsonRegistro = json_decode(file_get_contents("php://input"), false);
                $email = $jsonRegistro->email;
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


                if ($objeto->existe(['email' => $email])) {
                    //cargamos el objeto usuario llamammos a la funcion y le decimos que el email que nos pasa tiene que ser igual al email de la base de datos 
                    $http->setHttpHeaders(600, new Response("El $controller con el $email esta registrado", $email));
                } else {

                    foreach ($jsonRegistro as $c => $v) {

                        if ($c != "localidad") {
                            $objeto->$c = $v;
                        } else {

                            $objeto->localidad = $localidad;
                        }
                    }


                    //   $usuario = new usuario();
                    //$objeto->setpass(PASSWORD_BCRYPT);
                    $objeto->save();

                    $http->setHttpHeaders(200, new Response("Lista $controller", (string) $objeto));
                }




                break;
            case "login":
                $jsonlogin = json_decode(file_get_contents("php://input"), false);
                $email = $jsonlogin->email;
                $pass = $jsonlogin->pass;


                $datos = $objeto->login($email, $pass);

                $http->setHttpHeaders(200, new Response("Lista $controller", (String) $datos));
                break;

            case "existe":
                $jsonlogin = json_decode(file_get_contents("php://input"), false);
                $email = $jsonlogin->email;
                $datos = $objeto->existeft(['email' => $email]);
                $http->setHttpHeaders(200, new Response("Lista $controller", $datos));


                break;



            case "logout":
                $body = file_get_contents('php://input');
                $json = json_decode($body);
                $datos = $objeto->logout($json->idusuario);
                $http->setHTTPHeaders(200, new Response("This: ", (string) $datos));
                break;
        } //switch funcin
    }//POST 
} catch (Exception $ex) {
    
}
