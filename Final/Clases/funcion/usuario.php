<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-type: application/json');
header('Access-Control-Max-Age: 1000');
header("Access-Control-Allow-Credentials: true");
require_once '../Localidad.php';


try {

    if ($verb == 'GET') {

        switch (strtolower($funcion)) {



            case "existe":
                $jsonlogin = json_decode(file_get_contents("php://input"), false);
                $email = $jsonlogin->email;


                $datos = $objeto->idexiste(['email' => $email]);
                $http->setHttpHeaders(200, new Response("Lista $controller", $datos));


                break;
        }
    } else {
        
    }

    if ($verb == 'POST') {

        switch (strtolower($funcion)) {
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
                            
                             $objeto->localidad=$localidad;
                           
                        }
                    }
             
                    $objeto->save();
                    
                    $http->setHttpHeaders(200, new Response("Lista $controller", $objeto));
                }


                break;
            case "login":
                $jsonlogin = json_decode(file_get_contents("php://input"), false);
                $email = $jsonlogin->email;
                $pass = $jsonlogin->pass;
                
                $datos = $objeto->login($email, $pass);

                $http->setHttpHeaders(200, new Response("Lista $controller", $datos));
                break;
            
            
            
               case "logout":
                $body = file_get_contents('php://input');
                $json = json_decode($body);
                $datos = $objeto->logout($json->id);
                $http->setHTTPHeaders(200, new Response("This: ", $datos));
                break;
            
            
            
            
            
            
        } //switch funcin
    }//POST 
} catch (Exception $ex) {
    
}