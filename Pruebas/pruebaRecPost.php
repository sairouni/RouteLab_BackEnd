<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once '../Final/Rec-Post.php';
        require_once '../Final/Post.php';
        require_once '../Final/Recomendaciones.php';


        $b = new RecAsociada();
        $d = new Recomendaciones();
        $d->load(1);
        $b->recomendaciones = $d;
        $j = new Post();
        $j->load(1);
        $b->post = $j;
        print_r($d);
        print_r($j);
        $b->save();
        ?>
    </body>
</html>
