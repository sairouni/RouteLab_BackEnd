<?php

require_once 'basededatos.php';
require_once 'usuario.php';
require_once 'post.php';

class comentariopost extends BasedeDatos {

    private $idcomentario;
    private $idusuario;
    private $comentario;
    private $idpost;
    private $num_fields = 4;

    function __construct() {
        $show = ["idcomentario"]; //duda
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
        parent::__construct("comentariopost", "idcomentario", $fields, $show);
    }

    function getIdcomentario() {         //duda ponemos set?  , duda ponemos como centro?
        return $this->idcomentario;
    }

    function getidusuario() {
        return $this->idusuario;
    }
    
    function getComentario() {
        return $this->comentario;
    }

    function getIdpost() {
        return $this->idpost;
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
    
}
