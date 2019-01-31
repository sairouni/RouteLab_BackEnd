<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once 'Clases/Post.php';
        require_once 'Clases/valoracion.php';
        
        $b = new Post();
        $b->load(1);
        echo $b->media();
        ?>
    </body>
</html>
