<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once 'Clases/valoracion.php';
        require_once 'Clases/usuario.php';
        require_once 'Clases/Post.php';


        $b = new Valoracion();
        $d = new usuario();
        $d->load(2);
        $b->idusuario = $d;
        $j = new Post();
        $j->load(3);
        $b->idpost = $j;
        $b->valoracion=4;
        print_r($d);
        print_r($j);
        $b->save();
        ?>
    </body>
</html>
