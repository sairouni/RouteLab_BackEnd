<html>
   <head>
       <meta charset="UTF-8">
       <title></title>
   </head>
   <body>
       <?php
       
       require_once'usuario.php';
       require_once'localidad.php';
       require_once 'Post.php';

           /*$a = new usuario();
          $a->nombreusuario="marc_elcampeador";
          $a->nombre="marc";
          $a->email="marc@gmail.com";
          $a->nombre="marquitus";
          $a->fechanacimiento='1920-02-10';
          $a->pass="marcos";
          $a->foto="jfiejfef";
          $a->empresa="1";
          $a->nombre_empresa="Stucom";
          $c=new Localidad();
          $c->load(1);
          $a->localidad=$c;
          print_r($c);
          $a->save();*/
       
          
          $b = new Post();
          $b->titulo="La travesia en Argentina";
          $b->descripcion=" en esta travesia seras bien chido";
          $b->tipo="ruta";
          $b->save();
          $d = new usuario();
          $d->load(4);
          $b->usuario=$d;
          print_r($d);
           
    
       ?>
   </body>
</html>
