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

    function getidusuario() {
        return $this->idusuario;
    }

    function getIdpost() {
        return $this->idpost;
    }
    
    function getValoracion() {
        return $this->valoracion;
    }

    function setidusuario( $usuario) {
        $this->idusuario = $usuario;
    }

    function setidpost($idpost) {
        $this->idpost = $idpost;
    }
    
    function setvaloracion($valoracion) {
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

    function save() { //duda
        $valoracion = $this->valores();
        unset($valoracion['idvaloracion']);
        
        if (empty($this->idvaloracion)) {
            $this->insert($valoracion);
            $this->idvaloracion = self::$conn->lastInsertId();
        } else {
            $this->update($this->idvaloracion, $valoracion);
        }
    }
    
    /*
     * Función para calcular la media, definida en esta clase para coger el id 
     * del post y llamarlo en la clase Post. Devuelve todos los valores de un 
     * id (en este caso el id de un post) cogiendolos mediante la función 
     * getAll definida en esta misma clase.
     */
    function getValoracionByPost($id){
       return $this->getAll(['idpost'=>$id]);
    }
}
