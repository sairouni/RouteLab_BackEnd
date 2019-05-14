<?php

require_once 'basededatos.php';
require_once 'localidad.php';
require_once 'post.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Asociada
 *
 * @author isma_
 */
class Asociada extends BasedeDatos {

    private $idasociada; //int
    private $idlocalidad; //string
    private $idpost; //string
    private $num_fields = 3;

    function __construct() {
        $show = ["idasociada"]; //duda
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
        parent::__construct("asociada", "idasociada", $fields, $show);
    }

    function getIdasociada() {         //duda ponemos set?  , duda ponemos como centro?
        return $this->idasociada;
    }

    function getidlocalidad() {
        return $this->idlocalidad;
    }

    function getidpost() {
        return $this->idpost;
    }

    function setidlocalidad($localidad) {
        $this->idlocalidad = $localidad;
    }

    function setidpost($idpost) {
        $this->idpost = $idpost;
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
        $asociada = $this->getById($id);
        if (!empty($asociada)) {
            $this->idasociada = $id;
            $localidad = new Localidad();
            $post = new Post();
            $localidad->load($asociada['idlocalidad']);
            $this->idlocalidad = $localidad->serialize();
            $post->load($asociada['idpost']);
            $this->idpost = $post->serialize();
           } else {
            throw new Exception("No existe ese registro");
        }
    }

    function delete() { //dudaa
        if (!empty($this->idasociada)) {
            $this->deleteById($this->idasociada);
            $this->idasociada = null;
            $this->idpost = null;
            $this->idlocalidad = null;
        } else {
            throw new Exception("No hay registro para borrar");
        }
    }

    function save() { //duda
        $asociada = $this->valores();
        unset($asociada['idasociada']);
        if (empty($this->idasociada)) {
            $this->insert($asociada);
            $this->idasociada = self::$conn->lastInsertId();
        } else {
            $this->update($this->idasociada, $asociada);
        }
    }

    public function getbyIdAso($id) {
        $post = $this->getAll(['idpost' => $id]);
        if (!empty($post)) {
            return $post;
        } else {
            throw new Exception("No existe ese registro");
        }
    }

}
