<?php

require_once 'basededatos.php';
require_once 'usuario.php';
require_once 'valoracion.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of alumno
 *
 * @author isma_
 */
class Post extends BasedeDatos {

    //Las propiedades mapean las existentes en la base de datos
    private $idpost;
    private $titulo;
    private $descripcion;
    private $usuario;
    private $tipo;
    private $imagen;
    private $idvaloracion;
    private $num_fields = 7;

    function __construct() {
        $show = ["titulo"];
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
        parent::__construct("post", "idpost", $fields, $show);
    }

    function getIdpost() {
        return $this->idpost;
    }

    function getTitulo() {

        return $this->titulo;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getUsuario(): Usuario {
        return $this->usuario;
    }

    function getValoracion(): Valoracion {
        return $this->idvaloracion;
    }

    function getImagen() {
        return $this->imagen;
    }

    function setUsuario(Usuario $usuario) {
        $this->usuario = $usuario;
    }

    function setValoracion(Valoracion $idvaloracion) {
        $this->idvaloracion = $idvaloracion;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setidusuario($id) {
        $usuario = new Usuario();
        $usuario->load($id);
        $this->usuario = $usuario;
    }

    function setidvaloracion($id) {
        $usuario = new Valoracion();
        $usuario->load($id);
        $this->idvaloracion = $valoracion;
    }

    function setImagen($imagen) {
        $this->imagen = $imagen;
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
        $post = $this->getById($id);

        if (!empty($post)) {
            $this->idpost = $id;
            $this->titulo = $post['titulo'];
            $this->descripcion = $post['descripcion'];
            $this->tipo = $post['tipo'];
            $usuario = new Usuario();
            $usuario->load($post['idusuario']);
            $this->usuario = $usuario;
            $valoracion = new Valoracion();
            $valoracion->load($post['idvaloracion']);
            $this->idvaloracion = $valoracion;
            $this->imagen = $post['imagen'];
        } else {
            throw new Exception("No existe ese registro");
        }
    }

    function delete() {
        if (!empty($this->idpost)) {
            $this->deleteById($this->idpost);
            $this->idpost = null;
            $this->titulo = null;
            $this->descripcion = null;
            $this->usuario = null;
            $this->idvaloracion = null;
            $this->imagen = null;
            $this->tipo = null;
        } else {
            throw new Exception("No hay registro para borrar");
        }
    }

    function save() {
        $post = $this->valores();
        unset($post['idpost']);
        $this->usuario->save();
        $post['idusuario'] = $this->usuario->idusuario;
        unset($post['usuario']);
        if (empty($this->idpost)) {
            $this->insert($post);
            $this->idpost = self::$conn->lastInsertId();
        } else {
            $this->update($this->idpost, $post);
        }
    }

    /*
     * Función media que calcula la media llamando a la funcion de la clase
     * Valoracion. Recoge todas las valoraciones de un id Post en concreto
     * y la almacena en una variable que pasa a ser un Array. Recorremos el
     * array valores y las guardamos en una variable sumandolas cada vez que
     * se recorre el array. Devuelve el valor dividido por la cantidad de 
     * valoraciones totales que ha tenido el post.
     */

    function media($id) {
        $b = new Valoracion();
        $valores = $b->getValoracionByPost($id);
        $med = 0;
        foreach ($valores as $valor) {

            $med += $valor['valoracion'];
        }
        return $med / count($valores);
    }

    function markers($id) {
        $a = new asociada();
        // $marker = $a->getAll(['idasociada' => $id]);
        $marker = $a->getbyIdAso($id);
        $localidades = [];
        if (!empty($marker)) {
            for ($i = 0; $i < count($marker); $i++) {
                $mar = $marker[$i];
                $localidad = new Localidad();
                $localidad->load($mar['idlocalidad']);
                $localidades[$i] = $localidad->serialize();
                //$comnetario[$i]['usuario']=$usuario->serialize();
            }
            return $localidades;
        } else {
            throw new Exception("No existe ese registro");
        }
    }

    function savePost($json) {
        var_dump($json);
        die();
        $object = new Post();
        foreach ($json as $item => $value) {
            if ($item == 'usuario') {
                $object->setidusuario($value);
            } else {
                $object->$item = $value;
            }
        }
        return $object;
    }

    public function getbyIdPost($id) {
        $post = $this->getById($id);
        if (!empty($post)) {
            return $post;
        } else {
            throw new Exception("No existe ese registro");
        }
    }

}

//$a = new Alumno();
//$a->load(1);

//$a->titulo="Juan";
//$a->save();

//$a->delete();
