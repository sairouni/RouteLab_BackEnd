<?php

require_once 'BasedeDatos.php';
require_once 'usuario.php';
require_once 'Post.php';

class Valoracion extends BasedeDatos {

    private $idvaloracion; //int 
    private $idusuario; //int
    private $idpost; //int
    private $valoracion; //int
    private $num_fields = 4;

    function __construct() {
        $show = ["idvaloracion"]; //duda
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
        parent::__construct("valoracion", "idvaloracion", $fields, $show);
    }

    function getIdvaloracion() {         //duda ponemos set?  , duda ponemos como centro?
        return $this->idvaloracion;
    }

    function getIdusuario() : usuario {
        return $this->idusuario;
    }

    function getIdpost(): Post {
        return $this->idpost;
    }
    
    function getValoracion() {
        return $this->valoracion;
    }

    function setIdusuario(usuario $usuario) {
        $this->idusuario = $usuario;
    }

    function setIdpost(Post $idpost) {
        $this->idpost = $idpost;
    }
    
    function setValoracion($valoracion) {
        $this->valoracion = $valoracion;
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
        $valoracion = $this->getById($id);

        if (!empty($valoracion)) {
            $this->idvaloracion = $id;
            $usuario = new usuario();
            $usuario->load($valoracion['idusuario']);
            $this->usuario = $usuario;
            $post = new Post();
            $post->load($valoracion['idpost']);
            $this->post = $post;
            $this->valoracion = $valoracion['valoracion'];
        } else {
            throw new Exception("No existe ese registro");
        }
    }

    function delete() { //dudaa
        if (!empty($this->idvaloracion)) {
            $this->deleteById($this->idvaloracion);
            $this->idvaloracion = null;
            $this->idusuario = null;
            $this->idpost = null;
            $this->valoracion = null;
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

    function save() { //duda
        $valoracion = $this->valores();
        unset($valoracion['idvaloracion']);

        $this->idusuario->save();
        $valoracion['idusuario'] = $this->idusuario->idusuario;
        unset($valoracion['usuario']);

        $this->idpost->save();
        $valoracion['idpost'] = $this->idpost->idpost;
        unset($valoracion['post']);
        if (empty($this->idvaloracion)) {
            $this->insert($valoracion);
            $this->idvaloracion = self::$conn->lastInsertId();
        } else {
            $this->update($this->idvaloracion, $valoracion);
        }
    }

}