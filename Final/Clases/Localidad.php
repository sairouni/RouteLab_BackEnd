<?php
require_once 'BasedeDatos.php';
require_once 'api.php';
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
   private $pais;
   private $poblacion;
   private $direccion;
   private $latitud;
   private $longitud;
   private $num_fields=6;




   function __construct() {
       $show = ["pais"];
       $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
       parent::__construct("localidad", "idlocalidad", $fields, $show);
   }





function getidLocalidad() {
       return $this->idlocalidad;
   }

   function getPais() {

       return $this->pais;
   }

   function getLatitud() {
       return $this->latitud;
   }
   function getLongitud() {
       return $this->longitud;
   }

   function getPoblacion() {
       return $this->poblacion;
   }

   function getDireccion() {
       return $this->direccion;
   }

   function setPoblacion($poblacion) {
       $this->poblacion = $poblacion;
   }

   function setDireccion($direccion) {
       $this->direccion = $direccion;
   }

      function setPais($pais) {
       $this->pais = $pais;
   }

   function setLatitud($latitud) {
       $this->latitud = $latitud;
   }

   function setLongitud($longitud) {
       $this->longitud = $longitud;
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
           $this->pais = $localidad['pais'];
           $this->latitud = $localidad['latitud'];
           $this->poblacion= $localidad['poblacion'];
           $this->direccion=$localidad['direccion'];
           $this->longitud = $localidad['longitud'];
       } else {
           throw new Exception("No existe ese registro");
       }
   }



function delete() {
       if (!empty($this->idlocalidad)) {
           $this->deleteById($this->idlocalidad);
           $this->idlocalidad = null;
           $this->pais = null;
           $this->poblacion=null;
           $this->direccion=null;
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

   function loca($body){
       $aa = $this->getAll($body);
 
            if ($aa->idexiste(['latitud' => $aa,'longitud' => $aa])) {

                    return "Existe";
                } else {
                     return "No Existe";
                }
       
       
       
       
       
   }
  
   
}

//$a = new Alumno();
//$a->load(1);

//$a->pais="Juan";
//$a->save();

//$a->delete();
