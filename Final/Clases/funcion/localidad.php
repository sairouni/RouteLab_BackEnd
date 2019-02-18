<?php

try {

    if ($verb == 'GET') {

        switch (strlower($funcion)) {
            
        }
    } else {
        
    }

    if ($verb == 'POST') {
        switch (strtolower($funcion)) {

            case "registro":
                $jsonRegistro = json_decode(file_get_contents("php://input"), false);
                $latitud = $jsonRegistro->latitud;
                $longitud = $jsonRegistro->longitud;

                if ($objeto->existe(['latitud' => $latitud]) && $objeto->existe(['longitud' => $longitud])) {

                    $http->setHttpHeaders(601, new Response("la $controller con la $latitud y la $longitud ya existe ", $latitud . " / " . $longitud));
                } else {
                    foreach ($jsonRegistro as $c => $v) {
                        //$c=="idlocalidad"
                        $objeto->$c = $v;
                    }
                    $objeto->save();
                }



                break;
        }
    }
} catch (Exception $ex) {
    
}