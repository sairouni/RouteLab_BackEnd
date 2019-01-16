<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once 'Post.php';
        require_once 'valoracion.php';
        
        $b = new Post();
        $b->load(1);
        echo $b->media();
        ?>
    </body>
</html>
