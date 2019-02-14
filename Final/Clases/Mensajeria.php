<?php

require_once 'BasedeDatos.php';
require_once 'usuario.php';

/**
 * Description of centro
 *
 * @author dam
 */
class Mensajeria extends BasedeDatos {

    //Las propiedades mapean las existentes en la base de datos
    private $idmensaje;
    private $receptor;
    private $emisor;
    private $fecha;
    private $hora;
    private $mensaje;
    private $num_fields = 6;

    function __construct() {
        $show = ["mensaje"];
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
        parent::__construct("mensajeria", "idmensaje", $fields, $show);
    }

    function getIdmensaje() {
        return $this->idmensaje;
    }

    function getEmisor() {
        return $this->emisor;
    }

    function getReceptor() {
        return $this->receptor;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getHora() {
        return $this->hora;
    }

    function getMensaje() {
        return $this->mensaje;
    }

    function setEmisor( $idusuario) {
        $this->emisor = $idusuario;
    }

    function setReceptor( $idusuario) {
        $this->receptor = $idusuario;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setHora($hora) {
        $this->hora = $hora;
    }

    function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
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
        $mensaje = $this->getById($id);

        if (!empty($mensaje)) {
            $this->idmensaje = $id;
            $receptor=new Usuario();
            $receptor->load($mensaje['idreceptor']);
            $this->receptor = $receptor;
            $emisor=new Usuario();
            $emisor->load($mensaje['idemisor']);
            $this->emisor = $emisor;
            $this->fecha = $mensaje['fecha'];
            $this->hora = $mensaje['hora'];
            $this->mensaje = $mensaje['mensaje'];
        } else {
            throw new Exception("No existe ese registro");
        }
    }

    function delete() {
        if (!empty($this->idmensaje)) {
            $this->deleteById($this->idmensaje);
            $this->idmensaje = null;
            $this->receptor = null;
            $this->emisor = null;
            $this->fecha = null;
            $this->hora = null;
            $this->mensaje = null;
        } else {
            throw new Exception("No hay registro para borrar");
        }
    }
    function save() {
        $mensaje = $this->valores();
        unset($mensaje['idmensaje']);
        var_dump($this->receptor);
        $mensaje['idreceptor']=$this->receptor->idusuario;
        unset($mensaje['receptor']);
        $mensaje['idemisor']=$this->emisor->idusuario;
        unset($mensaje['emisor']);
        if (empty($this->idmensaje)) {
            $this->insert($mensaje);
            $this->idmensaje = self::$conn->lastInsertId();
        } else {
            $this->update($this->idmensaje, $mensaje);
        }
    }

}
