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
class Localidad extends BasedeDatos {

   //Las propiedades mapean las existentes en la base de datos
   private $idlocalidad;
   private $nombre;
   private $latitud;
   private $longitud;
   private $num_fields=4;




   function __construct() {
       $show = ["nombre"];
       $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
       parent::__construct("localidad", "idlocalidad", $fields, $show);
   }





function getidLocalidad() {
       return $this->idlocalidad;
   }

   function getNombre() {

       return $this->nombre;
   }

   function getLatitud() {
       return $this->latitud;
   }
   function getLongitud() {
       return $this->longitud;
   }

   function setLongitud($longitud) {
       $this->longitud = $longitud;
   }

      function setNombre($nombre) {
       $this->nombre = $nombre;
   }

   function setLatitud($latitud) {
       $this->latitud = $latitud;
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
       $localidad = $this->getById($id);

       if (!empty($localidad)) {
           $this->idlocalidad = $id;
           $this->nombre = $localidad['nombre'];
           $this->latitud = $localidad['latitud'];
           $this->longitud = $localidad['longitud'];
       } else {
           throw new Exception("No existe ese registro");
       }
   }





function delete() {
       if (!empty($this->idlocalidad)) {
           $this->deleteById($this->idlocalidad);
           $this->idlocalidad = null;
           $this->nombre = null;
           $this->latitud = null;
           $this->longitud=null;
       } else {
           throw new Exception("No hay registro para borrar");
       }
   }


   function save() {
       $localidad = $this->valores();
       unset($localidad['idlocalidad']);
       if (empty($this->idlocalidad)) {
           $this->insert($localidad);
           $this->idlocalidad = self::$conn->lastInsertId();
       } else {
           $this->update($this->idlocalidad, $localidad);
       }
   }
}

//$a = new Alumno();
//$a->load(1);

//$a->nombre="Juan";
//$a->save();

//$a->delete();
