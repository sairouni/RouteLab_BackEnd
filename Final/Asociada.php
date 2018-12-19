<?php

require_once 'BasedeDatos.php';
require_once 'Localidad.php';
require_once 'Post.php';
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
    private $localidad; //string
    private $idpost; //string
     private $num_fields=3;
    
    
      function __construct() {
        $show=["idasociada"]; //duda
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
       parent::__construct("asociada","idasociada", $fields, $show);
        
    }
    
    function getIdasociada() {         //duda ponemos set?  , duda ponemos como centro?
        return $this->idasociada;
    }


    function getlocalidad(): Localidad {
        return $this->localidad;
    }

    function getpost() : Post {
        return $this->idpost;
    }

    function setlocalidad(Localidad $localidad) {
        $this->localidad = $localidad;
    }

    function setpost(Post $idpost) {
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
            $localidad=new Localidad();
            $localidad->load($asociada['idlocalidad']);
            $this->localidad = $localidad;
            $post=new Post();
            $post->load($asociada['idpost']);
            $this->post = $post;
       } else {
           throw new Exception("No existe ese registro");
       }
   }
   
   
   function delete() { //dudaa
       if (!empty($this->idasociada)) {
           $this->deleteById($this->idasociada);
           $this->idasociada = null;
           $this->idpost = null;
           $this->localidad = null;
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
        $asociada = $this->valores();
       unset($asociada['idasociada']);
       
       $this->localidad->save();
        $asociada['idlocalidad']=$this->localidad->idlocalidad;
        unset($asociada['localidad']);
        
         $this->post->save();
        $asociada['idpost']=$this->post->idpost;
        unset($asociada['post']);
       if (empty($this->idasociada)) {
           $this->insert($asociada);
           $this->idasociada = self::$conn->lastInsertId();
       } else {
           $this->update($this->idasociada, $asociada);
       }
   }
    
    
    
}
