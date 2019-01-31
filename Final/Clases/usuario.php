<?php
require_once 'BasedeDatos.php';
require_once 'Localidad.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usuario
 *
 * @author isma_
 */
class usuario extends BasedeDatos{
    //put your code here
    
    private $idusuario; //int
    private $nombreusuario; //string
    private $email; //string
    private $pass; //string
    private $nombre; //string
    private $fechanacimiento; //int
    private $localidad; //string
    private $foto;
    private $empresa;
    private $nombre_empresa;
    private $num_fields=10;
    
   function __construct() {
        $show=["nombreusuario"];
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
       parent::__construct("usuario","idusuario", $fields, $show);
        
    }
    
    function getidusuario() {
        return $this->idusuario;
    }
     function getnombreusuario() {
        return $this->nombreusuario;
    }
       
    function getEmpresa() {
        return $this->empresa;
    }

    function getNombre_empresa() {
        return $this->nombre_empresa;
    }

    function setEmpresa($empresa) {
        $this->empresa = $empresa;
    }

    function setNombre_empresa($nombre_empresa) {
        $this->nombre_empresa = $nombre_empresa;
    }

        function setnombreUsuario($nombreusuario){
         $this->nombreusuario=$nombreusuario;      
    }
 

    function getFoto() {
        return $this->foto;
    }

    function setFoto($foto) {
        $this->foto = $foto;
    }
    
    
    
        function getemail(){
        
        return $this->email;
    }
    
    function setemail($email){
        
        $this->email=$email;
        
    }
      
    
    function getpass(){
        return $this->pass;
        
    }
      function setpass($pass){
        
        $this->pass=$pass;
        
    }
    function getnombre(){
        return $this->nombre;
    }
      
    function setnombre($nombre){
        
        $this->nombre=$nombre;
        
    }
    function getfechanacimiento(){
        
     return $this->fechanacimiento;   
     
    }
    
      function setfechanacimiento($fechanacimiento){
        
        $this->fechanacimiento=$fechanacimiento;
        
    }
      
    function getlocalidad(): Localidad{
        return $this->localidad;
        
    }



   function setlocalidad(Localidad $localidad){
        
        $this->localidad=$localidad;
        
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
       $usuario = $this->getById($id);

       if (!empty($usuario)) {
           $this->idusuario = $id;
           $this->nombreusuario = $usuario['nombreusuario'];
            $this->nombre = $usuario['nombre'];
           $this->pass = $usuario['pass'];
           $this->email = $usuario['email'];
           $this->fechanacimiento = $usuario['fechanacimiento'];
           $this->foto = $usuario['foto'];
           $this->empresa = $usuario['empresa'];
           $this->nombre_empresa = $usuario['nombre_empresa'];
           $localidad=new Localidad();
           $localidad->load($usuario['idlocalidad']);
           $this->localidad = $localidad;
           
       } else {
           throw new Exception("No existe ese registro");
       }
   }
   
   
   
   function delete() {
       if (!empty($this->idusuario)) {
           $this->deleteById($this->idusuario);
           $this->idusuario = null;
           $this->nombreusuario = null;
           $this->nombre = null;
           $this->pass = null;
           $this->email = null;
           $this->fechanacimiento = null;
           $this->localidad = null;
           $this->foto = null;
           $this->empresa=null;
           $this->nombre_empresa=null;
       } else {
           throw new Exception("No hay registro para borrar");
       }
   }
   

    
       function save() {
       $usuario = $this->valores();
       unset($usuario['idusuario']);
       $this->localidad->save();
       $usuario['idlocalidad']=$this->localidad->idlocalidad;
        unset($usuario['localidad']);
       if (empty($this->idusuario)) {
           $this->insert($usuario);
           $this->idusuario = self::$conn->lastInsertId();
       } else {
           $this->update($this->idusuario, $usuario);
       }
   }
    
}