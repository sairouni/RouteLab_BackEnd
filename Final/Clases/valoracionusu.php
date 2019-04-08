<?php

require_once 'basededatos.php';
require_once 'usuario.php';

class ValoracionUsu extends BasedeDatos {

    private $idVusu; //int 
    private $idusuario; //int
    private $idvalorado; //int
    private $valoracion; //int
    private $num_fields = 4;

    function __construct() {
        $show = ["idVusu"]; //duda
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
        parent::__construct("valoracionusu", "idVusu", $fields, $show);
    }

    function getIdvaloracion() {       
        return $this->idVusu;
    }

    function getidusuario() {
        return $this->idusuario;
    }

    function getIdvalorado() {
        return $this->idvalorado;
    }
    
    function getValoracion() {
        return $this->valoracion;
    }

    function setidusuario( $usuario) {
        $this->idusuario = $usuario;
    }

    function setidvalorado($idvalorado) {
        $this->idvalorado = $idvalorado;
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
            $this->idVusu = $id;
            $usuario = new usuario();
            $usuario->load($valoracion['idusuario']);
            $this->usuario = $usuario;
            $valorado = new usuario();
            $valorado->load($valoracion['idvalorado']);
            $this->valorado = $valoracion;
            $this->valoracion = $valoracion['valoracion'];
        } else {
            throw new Exception("No existe ese registro");
        }
    }

    function delete() { //dudaa
        if (!empty($this->idVusu)) {
            $this->deleteById($this->idVusu);
            $this->idVusu = null;
            $this->idusuario = null;
            $this->idvalorado = null;
            $this->valoracion = null;
        } else {
            throw new Exception("No hay registro para borrar");
        }
    }

    function save() { //duda
        $valoracion = $this->valores();
        unset($valoracion['idvaloracion']);
        
        if (empty($this->idVusu)) {
            $this->insert($valoracion);
            $this->idVusu = self::$conn->lastInsertId();
        } else {
            $this->update($this->idVusu, $valoracion);
        }
    }
    
    /*
     * Función para calcular la media, definida en esta clase para coger el id 
     * del post y llamarlo en la clase Post. Devuelve todos los valores de un 
     * id (en este caso el id de un post) cogiendolos mediante la función 
     * getAll definida en esta misma clase.
     */
    function getValoracionByUsuario($id){
       return $this->getAll(['idvalorado'=>$id]);
    }
}
