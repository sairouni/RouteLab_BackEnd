<?php
require_once 'BasedeDatos.php';

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
class Recomendaciones extends BasedeDatos {

   //Las propiedades mapean las existentes en la base de datos
   private $idrec;
   private $icono;
   private $descripcion;
   private $num_fields=3;




   function __construct() {
       $show = ["icono"];
       $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
       parent::__construct("recomendaciones", "idrec", $fields, $show);
   }





function getidRec() {
       return $this->idrec;
   }

   function getIcono() {

       return $this->icono;
   }

   function getDescripcion() {
       return $this->descripcion;
   }


      function setIcono($icono) {
       $this->icono = $icono;
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
       $recomendaciones = $this->getById($id);

       if (!empty($recomendaciones)) {
           $this->idrec = $id;
           $this->icono = $recomendaciones['icono'];
           $this->descripcion = $recomendaciones['descripcion'];
       } else {
           throw new Exception("No existe ese registro");
       }
   }





function delete() {
       if (!empty($this->idrec)) {
           $this->deleteById($this->idrec);
           $this->idrec = null;
           $this->icono = null;
           $this->descripcion = null;
       } else {
           throw new Exception("No hay registro para borrar");
       }
   }


   function save() {
       $recomendaciones = $this->valores();
       unset($recomendaciones['idrec']);
       if (empty($this->idrec)) {
           $this->insert($recomendaciones);
           $this->idrec = self::$conn->lastInsertId();
       } else {
           $this->update($this->idrec, $recomendaciones);
       }
   }
}

//$a = new Alumno();
//$a->load(1);

//$a->icono="Juan";
//$a->save();

//$a->delete();

