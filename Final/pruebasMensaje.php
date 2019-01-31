<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once 'Clases/classMensajeria.php';
        require_once 'Clases/usuario.php';

        $b = new Mensajeria();
        $b->fecha = "2018-12-13";
        $b->hora = "10:30";
        $d = new Usuario();
        $d->load(1);
        $b->emisor = $d;
        $j = new Usuario();
        $j->load(2);
        $b->receptor = $j;
        $b->mensaje="SHola que tal";
        print_r($d);
        print_r($j);
        $b->save();
        ?>
    </body>
</html>
