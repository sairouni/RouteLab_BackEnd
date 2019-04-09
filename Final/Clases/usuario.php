<?php
require_once 'basededatos.php';
require_once 'localidad.php';
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
    private $edad; //int
    private $localidad; //string
    private $foto;
    private $telefono;
    private $empresa;
    private $nombre_empresa;
    private $token;
    private $num_fields=12;
    
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
    
    
    function getTelefono() {
        return $this->telefono;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
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
    function getedad(){
        
     return $this->edad;   
     
    }
    
      function setedad($edad){
        
        $this->edad=$edad;
        
    }
      
    function getlocalidad(): Localidad{
        return $this->localidad;
        
    }



   function setlocalidad(Localidad $localidad){
        
        $this->localidad=$localidad;
        
    }
    function setidlocalidad($id){
        $localidad=new Localidad();
        $localidad->load($id);
        $this->localidad=$localidad;
    }
    
   
    function getToken() {
        return $this->token;
    }

    function setToken($token) {
        $this->token = $token;
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
           $this->edad = $usuario['edad'];
           $this->foto = $usuario['foto'];
           $this->empresa = $usuario['empresa'];
           $this->telefono= $usuario['telefono'];
           $this->nombre_empresa = $usuario['nombre_empresa'];
           $this->token= $usuario['token'];
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
           $this->edad = null;
           $this->telefono = null;
           $this->localidad = null;
           $this->foto = null;
           $this->empresa=null;
           $this->token=null;
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
   
       public function getbyToken($id)
    {
        $user = $this->getAll(['token' => $id]);
        if (!empty($user)) {
            return $user;
        } else {
            throw new Exception("No existe ese registro");
        }
    }

    

        public function login($email, $pass)
    {
       
            $user = $this->getAll(['email' => $email, 'pass' => $pass]);
            if (!empty($user)) {
                $usuario = new usuario();
                $usuario->load($user[0]["idusuario"]);
                $usuario->setToken(bin2hex(random_bytes(50)));
                $usuario->save();
                
              //  $user = $this->getAll(['email' => $email, 'pass' => $pass]);
                
                return $usuario;
            } else {
                throw new Exception("Error Login Datos incorrectos");
            }
      
        
    }
   
    
  public function logout($id)
    {
        try {
            if (!empty($id)) {
                $user = new usuario();
                $user->load($id);
                $user->setToken("");
                $user->save();
                return $id;
            } else {
                return 0;
            }
        } catch (Exception $ex) {
            return -1;
        }
    }
  
    function media($id) {
        $b = new ValoracionUsu();
        $valores = $b->getValoracionByUsuario($id);
        $med = 0;
        foreach ($valores as $valor) {
            
            $med += $valor['valoracion'];
        }
        return $med/count($valores);
        
    }
    
        function verUsu($id){
        
        $usuario= $this->getAll(['idusuario' => $id]);
            if (!empty($usuario)) {
         for($i=0;$i<count($usuario);$i++){
             $usu=$usuario[$i];
             $localidad= new Localidad();
             $localidad->load($usu['idlocalidad']);
             $usuario[$i]['localidad']=$localidad->serialize();
             //$comnetario[$i]['usuario']=$usuario->serialize();
         }
                return $usuario[0];
        } else {
            throw new Exception("No existe ese registro");
        }
        
        
    }
    
}