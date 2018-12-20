<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once 'valoracion.php';
        require_once 'usuario.php';
        require_once 'Post.php';


        $b = new Valoracion();
        $d = new usuario();
        $d->load(2);
        $b->idusuario = $d;
        $j = new Post();
        $j->load(1);
        $b->idpost = $j;
        $b->valoracion=9;
        print_r($d);
        print_r($j);
        $b->save();
        ?>
    </body>
</html>
