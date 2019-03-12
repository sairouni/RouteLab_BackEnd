<?php

try {

    if ($verb == 'GET') {

        switch (strlower($funcion)) {
            
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