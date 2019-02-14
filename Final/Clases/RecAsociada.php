<?php
require_once 'BasedeDatos.php';
require_once 'Recomendaciones.php';
require_once 'Post.php';

class RecAsociada extends BasedeDatos{
    
    private $idRecPost;//int
    private $post;
    private $rec;
    private $num_fields=3;

        
      function __construct() {
        $show=["idRecPost"]; //duda
        $fields = array_slice(array_keys(get_object_vars($this)), 0, $this->num_fields);
       parent::__construct("RecAsociada","idRecPost", $fields, $show);
        
    }
    
    function getidRecpost(){
        return $this->idRecPost;
    }
    
    
    function getRec(){
        return $this->rec;
    }
    
    
    function getPost(){
        
        return $this->post;
        
    }
    
    
    function setRec( $rec){
        
        $this->rec=$rec;
    }
    
     
    function setPost( $post){
        $this->post=$post;
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
            $this->idRecPost=$id;
            $post=new Post();
            $post->load($redAsociada['idpost']);
            $this->post = $post;
            $recomendaciones= new Recomendaciones();
            $recomendaciones->load($redAsociada['idrec']);
            $this->recomendaciones=$recomendaciones; 
        } //final del if load
        
    }//final del load
    
       function delete() {
       if (!empty($this->idRecPost)) {
           $this->deleteById($this->idRecPost);
           $this->idRecPost = null;
           $this->post = null;
           $this->rec = null;
       } else {
           throw new Exception("No hay registro para borrar");
       }
   }//final del delete
   
    
   function save(){
       $recasociada= $this->valores();
       unset($recasociada['recPost']);
        $this->post->save();
        $recasociada['idpost']=$this->post->idpost;
        unset($recasociada['post']);
        $this->recomendaciones->save();
        $recasociada['idrec']=$this->recomendaciones->idrec;
        unset($recasociada['recomendaciones']);
           if (empty($this->idRecPost)) {
           $this->insert($recasociada);
           $this->idRecPost = self::$conn->lastInsertId();
       } else {
           $this->update($this->idRecPost, $recasociada);
       }
       
       
       
       
       
       
       
   }
    
    
    
}