<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once 'Clases/Social.php';
        require_once 'Clases/usuario.php';

        $b = new Social();
        $d = new Usuario();
        $d->load(1);
        $b->idseguido = $d;
        $j = new Usuario();
        $j->load(2);
        $b->idseguidor = $j;
        print_r($d);
        print_r($j);
        $b->save();
        ?>
    </body>
</html>
