<?php
require_once 'basededatos.php';
require_once 'recomendaciones.php';
require_once 'post.php';

class RecAsociada extends BasedeDatos{
    
    private $idrecpost;//int
    private $idpost;
    private $idrec;
    private $num_fields=3;

        
      function __construct() {
        $show=["idrecpost"]; //duda
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
       parent::__construct("recasociada","idrecpost", $fields, $show);
        
    }
    
    function getidRecpost(){
        return $this->idrecpost;
    }
    
    
    function getidRec(){
        return $this->idrec;
    }
    
    
    function getidPost(){
        
        return $this->idpost;
        
    }
    
    
    function setidRec( $rec){
        
        $this->idrec=$rec;
    }
    
     
    function setidPost( $post){
        $this->idpost=$post;
    }
    
    
      function __get($name) {
       $metodo = "get$name";
       if (method_exists($this, $metodo)) {
           return $this->$metodo();
       } else {
           throw new Exception("Propiedad no encontrada");
       }
   }
   //geter magico

   function __set($name, $value) {
       $metodo = "set$name";
       if (method_exists($this, $metodo)) {
           return $this->$metodo($value);
       } else {
           throw new Exception("Propiedad  no encontrada");
       }
   } //seter maquico 
   

    function load($id){
        
        $redAsociada =$this->getById($id);
        if(!empty($redAsociada)){
            $this->idrecpost=$id;
            $this->idpost = $redAsociada['idpost'];
            $this->idrec = $redAsociada['idrec'];
            $recomendaciones= new Recomendaciones();
          
        } //final del if load
        
    }//final del load
    
       function delete() {
       if (!empty($this->idrecpost)) {
           $this->deleteById($this->idrecpost);
           $this->idrecpost = null;
           $this->idpost = null;
           $this->idrec = null;
       } else {
           throw new Exception("No hay registro para borrar");
       }
   }//final del delete
   
    
   function save(){
       $recasociada= $this->valores();
       unset($recasociada['idrecpost']);
           if (empty($this->idrecpost)) {
           $this->insert($recasociada);
           $this->idrecpost = self::$conn->lastInsertId();
       } else {
           $this->update($this->idrecpost, $recasociada);
       }
       
   }
   function recomendacion($id) {

        $rec = $this->getAll(['idpost' => $id]);
        if (!empty($rec)) {
            for ($i = 0; $i < count($rec); $i++) {
                $usu = $rec[$i];
                $us = new Recomendaciones();
                $us->load($usu['idrec']);
                $rec[$i]['recomendacion'] = $us->getDescripcion();
                $rec[$i]['descripcion']=$us->serialize();
                //$comnetario[$i]['usuario']=$usuario->serialize();
            }
            return $rec;
        } else {
            throw new Exception("No existe ese registro");
        }
    }
   public function getbyIdRec($id) {
        $post = $this->getAll(['idpost' => $id]);
        if (!empty($post)) {
            return $post;
        } else {
            throw new Exception("No existe ese registro");
        }
    }
    
    
    
}