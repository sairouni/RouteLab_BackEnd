<?php

require_once 'BasedeDatos.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usuario
 *
 * @author isma_
 */
class Usuario extends BasedeDatos {

    //put your code here

    private $idusuario; //int
    private $nombreusuario; //string
    private $nombre; //string
    private $pasword; //string
    private $email; //string
    private $fechaN; //date
    private $localidad; //string
    private $num_fields = 8;

    function __construct() {
        $show = ["nombreusuario"];
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
        parent::__construct("usuario", "idusuario", $fields, $show);
    }

    function getidusuario() {
        return $this->idusuario;
    }

    function getnombreusuario() {
        return $this->nombreusuario;
    }

    function getemail() {

        return $this->email;
    }

    function getpassword() {
        return $this->password;
    }

    function getnombre() {
        return $this->nombre;
    }

    function getedad() {

        return $this->fechaN;
    }

    function getlocalidad() {
        return $this->localidad;
    }

    function setnombreUsuario($nombreusuario) {

        $this->nombreusuario = $nombreusuario;
    }

    function setemail($email) {

        $this->email = $email;
    }

    function setpasword($pasword) {

        $this->password = $pasword;
    }

    function setnombre($nombre) {

        $this->nombre = $nombre;
    }

    function setedad($fechaN) {

        $this->fechaN = $fechaN;
    }

    function setlocalidad($localidad) {

        $this->localidad = $localidad;
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
            throw new Exception("Propiedad no encontrada");
        }
    }

    function load($id) {
        $usuario = $this->getById($id);

        if (!empty($usuario)) {
            $this->idusuario = $id;
            $this->nombreusuario = $usuario['nombreusuario'];
            $this->nombre = $usuario['nombre'];
            $this->pasword = $usuario['pass'];
            $this->email = $usuario['email'];
            $this->fechaN = $usuario['fechanacimiento'];
            $this->localidad = $usuario['idlocalidad'];
        } else {
            throw new Exception("No existe ese registro");
        }
    }

    function delete() {
        if (!empty($this->idusuario)) {
            $this->deleteById($this->idusuario);
            $this->idusuario = null;
            $this->nombreusuario = null;
            $this->nombre = null;
            $this->pasword = null;
            $this->email = null;
            $this->fechaN = null;
            $this->localidad = null;
        } else {
            throw new Exception("No hay registro para borrar");
        }
    }

    private function valores() {

        $valores = array_map(function($v) {
            return $this->$v;
        }, $this->fields);
        return array_combine($this->fields, $valores);
    }

    function save() {
        $usuario = $this->valores();
        unset($usuario['idusuario']);
        if (empty($this->idusuario)) {
            $this->insert($usuario);
            $this->idusuario = self::$conn->lastInsertId();
        } else {
            $this->update($this->idusuario, $usuario);
        }
    }

}
