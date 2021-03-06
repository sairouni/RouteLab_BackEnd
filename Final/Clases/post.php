<?php

require_once 'basededatos.php';
require_once 'usuario.php';
require_once 'valoracion.php';
require_once 'asociada.php';
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
    private $distancia;
    private $duracion;
    private $categoria;
    private $valoracion;
    private $num_fotos;
    private $num_fields = 9;

    function __construct() {
        $show = ["titulo"];
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
        parent::__construct("post", "idpost", $fields, $show);
        $this->valoracion = null;
        $this->num_fotos = null;
    }

    function getIdpost() {
        return $this->idpost;
    }

    function getDuracion() {
        return $this->duracion;
    }

    function setDuracion($duracion) {
        $this->duracion = $duracion;
    }

    function getDistancia() {
        return $this->distancia;
    }

    function setDistancia($distancia) {
        $this->distancia = $distancia;
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

    function getValoracion() {
        return $this->valoracion;
    }

    function getNum_fotos() {
        return $this->num_fotos;
    }

    function setNum_fotos($num_fotos) {
        $this->num_fotos = $num_fotos;
    }

    function setUsuario(Usuario $usuario) {
        $this->usuario = $usuario;
    }

    function setValoracion(Valoracion $valoracion) {
        $this->valoracion = $valoracion;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function getCategoria() {
        return $this->categoria;
    }

    function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setidusuario($id) {
        $usuario = new Usuario();
        $usuario->load($id);
        $this->usuario = $usuario;
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
            $this->categoria = $post['categoria'];
            $this->duracion = $post['duracion'];
            $this->distancia = $post['distancia'];
            $this->num_fotos = $post['num_fotos'];
            $usuario = new Usuario();
            $usuario->load($post['idusuario']);
            $this->usuario = $usuario;
            if (!empty($post['idvaloracion'])) {
                $valoracion = new Valoracion();
                $valoracion->load($post['idvaloracion']);
                $this->valoracion = $valoracion;
            }
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
            $this->valoracion = null;
            $this->categoria = null;
            $this->distancia = null;
            $this->duracion = null;
            $this->num_fotos = null;
        } else {
            throw new Exception("No hay registro para borrar");
        }
    }

    function save() {
        $post = $this->valores();
        unset($post['idpost']);

        $post['idusuario'] = $this->usuario->idusuario;
        unset($post['usuario']);

        if ($this->valoracion == null) {
            $post["idvaloracion"] = NULL;
        } else {
            $post["idvaloracion"] = $this->valoracion->idvaloracion;
        }
        unset($post['valoracion']);
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

        if ($med != 0) {
            return $med / count($valores);
        } else {
            return 0;
        }
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

    public function savePost($json) {
        $object = new Post();
        foreach ($json as $item => $value) {
            if ($item == 'usuario') {
                $object->setidusuario($value);
            } else {
                $object->$item = $value;
            }
        }
        $object->save();
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

    function postUsu($id) {
        $usuario = $this->getAll(['idusuario' => $id]);
        if (!empty($usuario)) {
            for ($i = 0; $i < count($usuario); $i++) {
                $usu = $usuario[$i];
                $us = new Usuario();
                $us->load($usu['idusuario']);
                $usuario[$i]['usuarioBuscado'] = $us->getnombreusuario();
//                $usuario[$i]['usuario'] = $us->serialize();
                //$comnetario[$i]['usuario']=$usuario->serialize();
            }
            return $usuario;
        } else {
            throw new Exception("No existe ese registro");
        }
    }

    function CiudadUsu($datos) {

        for ($i = 0; $i < count($datos); $i++) {
            $idlocalidad = $datos[$i]["idlocalidad"];
            $idlocalidades[] = $idlocalidad;
        }
        $base = $this->baselocalidades($idlocalidades);

        for ($i = 0; $i < count($base); $i++) {
            $bas = $base[$i];

            $post = new Post();
            $post->load($bas['idpost']);
            $base[$i]['idpost'] = $post->serialize();
        }
        return $base;
    }

}
