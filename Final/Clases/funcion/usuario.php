<?php

try {

    if ($verb == 'GET') {

        switch (strtolower($funcion)) {
            case "login":

                echo "TONTO";
                break;
        }
    } else {
        
    }

    if ($verb == 'POST') {

        switch (strtolower($funcion)) {
            case "login":
                $jsonLogin = json_decode(file_get_contents("php://input"), false);
                $jsonLogin->email->$email;
                $jsonLogin->pass->$password;

                if (!empty($email) and ! empty($password)) {
                    $query = 'select idusuario from usuario where email = "' . $email . '" and pass = "' . sha1($password) . '"';
                    $result = mysql_query($query) or die('error getting admin details : ' . mysql_error());

                    if (mysql_num_rows($result) == 1) {
                        $array = array("success" => "TRUE");
                        print(json_encode($array));
                    } else {
                        $array = array("error" => "Login invalid.");
                        print( json_encode($array));
                    }
                } else {
                    $array = array("error" => "Data not recieved.");
                    print( json_encode($array));
                }

                break;
            case "registro":
                $jsonRegistro = json_decode(file_get_contents("php://input"), false);
                $email = $jsonRegistro->email; // gaurdar variable pasada por el json 

                if ($objeto->existe(['email' => $email])) {
                    //cargamos el objeto usuario llamammos a la funcion y le decimos que el email que nos pasa tiene que ser igual al email de la base de datos 
                    $http->setHttpHeaders(600, new Response("El $controller con el $email esta registrado", $email));
                } else {

                    foreach ($jsonRegistro as $c => $v) {
                        //$c=="idlocalidad"
                        $objeto->$c = $v;
                    }
                    $objeto->save();
                }





                break;
        } //switch funcin
    }//POST 
} catch (Exception $ex) {
    
}