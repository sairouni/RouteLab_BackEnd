<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once '../Final/Asociada.php';
        require_once '../Final/localidad.php';
        require_once '../Final/post.php';


        $b = new Asociada();
        $d = new localidad();
        $d->load(1);
        $b->localidad = $d;
        $j = new Post();
        $j->load(1);
        $b->post = $j;
        print_r($d);
        print_r($j);
        $b->save();
        ?>
    </body>
</html>
