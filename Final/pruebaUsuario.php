<html>
   <head>
       <meta charset="UTF-8">
       <title></title>
   </head>
   <body>
       <?php
       
       require_once'Clases/usuario.php';
       require_once'Clases/localidad.php';
       require_once 'Clases/Post.php';

           $a = new usuario();
          $a->nombreusuario="marc_elcampeador2";
          $a->nombre="marc2";
          $a->email="marc2@gmail.com";
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
          $a->save();
       
          /*
          $b = new Post();
          $b->titulo="La travesia en Argentina";
          $b->descripcion=" en esta travesia seras bien chido";
          $b->tipo="ruta";
          $b->save();
          $d = new usuario();
          $d->load(4);
          $b->usuario=$d;
          print_r($d);
           */
    
       ?>
   </body>
</html>
