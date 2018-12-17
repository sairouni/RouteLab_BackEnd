<?php
require_once 'BasedeDatos.php';
require_once 'usuario.php';
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
   private $num_fields=5;




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
   function getUsuario():Usuario {
       return $this->usuario;
   }

   function setUsuario(Usuario $usuario) {
       $this->usuario = $usuario;
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
           $usuario=new Usuario();
           $usuario->load($usuario['idusuario']);
           $this->usuario = $usuario;
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
           $this->usuario=null;
           $this->tipo=null;
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
       $post = $this->valores();
       unset($post['idpost']);
       $this->usuario->save();
       $post['idusuario']=$this->usuario->idusuario;
       unset($post['usuario']);
       if (empty($this->idpost)) {
           $this->insert($post);
           $this->idpost = self::$conn->lastInsertId();
       } else {
           $this->update($this->idpost, $post);
       }
   }
}

//$a = new Alumno();
//$a->load(1);

//$a->titulo="Juan";
//$a->save();

//$a->delete();
