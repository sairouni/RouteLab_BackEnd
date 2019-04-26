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
            
        }
    } else {
        
    }

    if ($verb == 'POST') {
        switch (strtolower($funcion)) {
            case "addfoto":
                $body = file_get_contents('php://input');
                $json = json_decode($body);
                $files = $_FILES;
                if (isset($files["photo"])) {
                    if ($files["photo"] != "undefined") {
                        $ido = "id$controller";
                        $ruta = "./Assets/$controller" . "s/" . $objeto->$ido . ".jpg";
                        move_uploaded_file($files["photo"]["tmp_name"], $ruta);
                        if ($controller == "Project") {
                            $objeto->img = $ruta;
                        } else {
                            $objeto->photo = $ruta;
                        }
                        $objeto->save();
                    }
                }
                $http->setHTTPHeaders(201, new Response("Registro Insertado", $objeto->serialize()));


                break;
        }
    }
} catch (Exception $ex) {
    
}