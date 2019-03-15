<?php

require_once 'BasedeDatos.php';
require_once 'usuario.php';
require_once 'Post.php';

class comentPost extends BasedeDatos {

    private $idcomentario; //int 
    private $idusuario; //int
    private $idpost; //int
    private $comentario; //int
    private $num_fields = 4;

    function __construct() {
        $show = ["idcomentario"]; //duda
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
        parent::__construct("comentario", "idcomentario", $fields, $show);
    }

    function getIdcomentario() {         //duda ponemos set?  , duda ponemos como centro?
        return $this->idcomentario;
    }

    function getidusuario() {
        return $this->idusuario;
    }

    function getIdpost() {
        return $this->idpost;
    }
    
    function getComentario() {
        return $this->comentario;
    }

    function setidusuario( $usuario) {
        $this->idusuario = $usuario;
    }

    function setidpost($idpost) {
        $this->idpost = $idpost;
    }
    
    function setcomentario($comentario) {
        $this->comentario = $comentario;
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
        $comentario = $this->getById($id);

        if (!empty($comentario)) {
            $this->idcomentario = $id;
            $usuario = new usuario();
            $usuario->load($comentario['idusuario']);
            $this->usuario = $usuario;
            $post = new Post();
            $post->load($comentario['idpost']);
            $this->post = $post;
            $this->comentario = $comentario['comentario'];
        } else {
            throw new Exception("No existe ese registro");
        }
    }

    function delete() { //dudaa
        if (!empty($this->idcomentario)) {
            $this->deleteById($this->idcomentario);
            $this->idcomentario = null;
            $this->idusuario = null;
            $this->idpost = null;
            $this->comentario = null;
        } else {
            throw new Exception("No hay registro para borrar");
        }
    }

    function save() { //duda
        $comentario = $this->valores();
        unset($comentario['idcomentario']);
        
        if (empty($this->idcomentario)) {
            $this->insert($comentario);
            $this->idcomentario = self::$conn->lastInsertId();
        } else {
            $this->update($this->idcomentario, $comentario);
        }
    }
    
    /*
     * Función para calcular la media, definida en esta clase para coger el id 
     * del post y llamarlo en la clase Post. Devuelve todos los valores de un 
     * id (en este caso el id de un post) cogiendolos mediante la función 
     * getAll definida en esta misma clase.
     */
    function getComentByPost($id){
       return $this->getAll(['idpost'=>$id]);
    }
    
}
