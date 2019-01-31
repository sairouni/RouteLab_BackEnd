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
class Foto extends BasedeDatos {
    private $idfoto; //int
    private $localidad; //string
    private $idpost; //string
    private $url;
    private $num_fields=4;
    
    
      function __construct() {
        $show=["url"]; //duda
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
       parent::__construct("foto","idfoto", $fields, $show);
        
    }
    
    
    
    function getIdfoto() {         //duda ponemos set?  , duda ponemos como centro?
        return $this->idfoto;
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

    function getUrl() {
        return $this->url;
    }

    function setUrl($url) {
        $this->url = $url;
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
       $foto = $this->getById($id);

       if (!empty($foto)) {
            $this->idfoto = $id;
            $localidad=new Localidad();
            $localidad->load($foto['idlocalidad']);
            $this->localidad = $localidad;
            $post=new Post();
            $post->load($foto['idpost']);
            $this->post = $post;
           $this->url = $foto['url'];
       } else {
           throw new Exception("No existe ese registro");
       }
   }
   
   
   function delete() { //dudaa
       if (!empty($this->idfoto)) {
           $this->deleteById($this->idfoto);
           $this->idfoto = null;
           $this->idpost = null;
           $this->localidad = null;
           $this->url = null;
       } else {
           throw new Exception("No hay registro para borrar");
       }
   }

    
          function save() { //duda
       $foto = $this->valores();
       unset($foto['idfoto']);
       
        $this->localidad->save();
        $foto['idlocalidad']=$this->localidad->idlocalidad;
        unset($foto['localidad']);
        
         $this->post->save();
        $foto['idpost']=$this->post->idpost;
        unset($foto['post']);
       if (empty($this->idfoto)) {
           $this->insert($foto);
           $this->idfoto = self::$conn->lastInsertId();
       } else {
           $this->update($this->idfoto, $foto);
       }
   }
    
    
    
}
