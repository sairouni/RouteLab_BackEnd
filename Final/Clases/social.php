<?php

require_once 'basededatos.php';
require_once 'usuario.php';
/*
 * Marc: Comentario a tratar con Ismail.
 * Duda a tratar, cambiar el formato y dejar una primary key unica llamada 
 * idsocial en la base de datos. Ya que tuvimos problemas al entrar datos con
 * dos primary key. He probado su funcionamiento y funciona correctamente.
 */

class Social extends BasedeDatos {

    private $idsocial; //int
    private $idseguido; //string
    private $idseguidor; //string
    private $num_fields = 3;

    function __construct() {
        $show = ["idsocial"]; //duda
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
        parent::__construct("social", "idsocial", $fields, $show);
    }

    function getIdsocial() {
        return $this->idsocial;
    }

    function getIdseguido() {
        return $this->idseguido;
    }

    function getIdseguidor() {
        return $this->idseguidor;
    }

    function setIdseguido($idseguido) {
        $this->idseguido = $idseguido;
    }

    function setIdseguidor($idseguidor) {
        $this->idseguidor = $idseguidor;
    }

    function __get($name) {
        $metodo = "get$name";
        if (method_exists($this, $metodo)) {
            return $this->$metodo();
        } else {
            throw new Exception("Propiedad no encontrada");
        }
    }

    function __set($name, $value) {
        $metodo = "set$name";
        if (method_exists($this, $metodo)) {
            return $this->$metodo($value);
        } else {
            throw new Exception("Propiedad  no encontrada");
        }
    }

    function load($id) {
        $social = $this->getById($id);

        if (!empty($social)) {
            $this->idsocial = $id;
            $idseguido = new usuario();
            $idseguido->load($social['idseguido']);
            $this->idseguido = $idseguido;
            $idseguidor = new usuario();
            $idseguidor->load($social['idseguidor']);
            $this->idseguidor = $idseguidor;
        } else {
            throw new Exception("No existe ese registro");
        }
    }

    function delete() { //dudaa
        if (!empty($this->idsocial)) {
            $this->deleteById($this->idsocial);
            $this->idsocial = null;
            $this->idseguido = null;
            $this->idseguidor = null;
        } else {
            throw new Exception("No hay registro para borrar");
        }
    }

    function save() { //duda
        $social = $this->valores();
        unset($social['idsocial']);

        $this->idseguido->save();
        $social['idseguido'] = $this->idseguido->idusuario;
        // unset($social['idseguido']);

        $this->idseguidor->save();
        $social['idseguidor'] = $this->idseguidor->idusuario;
        //unset($social['idseguidor']);
        print_r($social);
        if (empty($this->idsocial)) {
            $this->insert($social);
            $this->idsocial = self::$conn->lastInsertId();
        } else {
            $this->update($this->idsocial, $social);
        }
    }

    function usuSeguido($id) {

        $usuario = $this->getAll(['idseguido' => $id]);
        if (!empty($usuario)) {
            for ($i = 0; $i < count($usuario); $i++) {
                $usu = $usuario[$i];
                $us = new Usuario();
                $us->load($usu['idseguido']);
                $usuario[$i]['usuarioSeguido'] = $us->getnombreusuario();
                $usuario[$i]['usuario']=$us->serialize();
                //$comnetario[$i]['usuario']=$usuario->serialize();
                
            }
            return $usuario;
        } else {
            throw new Exception("No existe ese registro");
        }
    }

    function usuSeguidor($id) {

        $usuario = $this->getAll(['idseguidor' => $id]);
        if (!empty($usuario)) {
            for ($i = 0; $i < count($usuario); $i++) {
                $usu = $usuario[$i];
                $us = new Usuario();
                $us->load($usu['idseguidor']);
                $usuario[$i]['usuarioSeguidor'] = $us->getnombreusuario();
                $usuario[$i]['usuario'] = $us->serialize();
                //$comnetario[$i]['usuario']=$usuario->serialize();
            }
            
            return $usuario;
        } else {
            throw new Exception("No existe ese registro");
        }
    }

}
