<!DOCTYPE html>

<html><head>
        <meta name="viewport" content="initial-scale=1.0, width=device-width" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>
        <title>Mantenimiento Usuarios</title>
    </head>
    <body>
        <div class="container">
            <div class="jumbotron">
                <h1>Mantenimiento Usuarios</h1>
            </div>
            <form method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre">
                </div>
                <div class="form-group">
                    <label for="nombre">Password:</label>
                    <input type="password" class="form-control" id="pasword" name="pasword">
                </div>
                <div class="form-group">
                    <label for="mail">Mail:</label>
                    <input type="text" class="form-control" id="mail"  name="mail">
                </div>
                
                 <div class="form-group">
                    <label for="mail">Edad:</label>
                    <input type="number" class="form-control" id="edad"  name="edad" value="16" min="16" max="102">
                </div>
                
                
                 <div class="form-group">
                    <label for="mail">Localidad:</label>
                    <input type="text" class="form-control" id="localidad"  name="localidad">
                </div>
                
                
                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <?php
            $nombre = filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_STRING);
            $pasword = filter_input(INPUT_POST, "pasword");
            $email = filter_input(INPUT_POST, "mail", FILTER_VALIDATE_EMAIL);
            $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
            $edad = filter_input(INPUT_POST, "edad", FILTER_VALIDATE_INT);
            $localidad = filter_input(INPUT_POST, "localidad", FILTER_SANITIZE_STRING);
           require_once 'DB.php';
           $usuario_t= new DB("usuario","idusuario","*",["nombre","email","edad","localidad"]);
            try {
               
                if (!empty($nombre) && !empty($email)&& !empty($pasword)) {
                   $usuario_t->insert(['nombre'=>$nombre, 'pasword'=>$pasword,'email'=>$email,'edad'=>$edad,'localidad'=>$localidad]);
                    
                        ?>
                        <div class="alert alert-success">
                            <strong>Correcto: </strong> Usuario insertado con exito
                        </div>
                        <?php
                    }
                
                    if (!empty($id) ) {
                    $usuario_t->deleteById($id)
                   
                        ?>
                        <div class="alert alert-success">
                            <strong>Correcto: </strong> Usuario eliminado con  id <?= $id ?>.
                        </div>
                        <?php
                    
                }
                $usuarios=$usuario_t->getAll();
                ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Mail</th>
                            <th>edad</th>
                            <th>localidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($usuarios as $usuario) {
                            ?>
                            <tr>
                                <td><?= $usuario['idusuario'] ?></td>
                                <td><?= $usuario['nombre'] ?></td>
                                <td><?= $usuario['email'] ?></td>
                                <td><?= $usuario['edad'] ?></td>
                                <td><?= $usuario['localidad'] ?></td>
                                <td><a class="btn btn-primary " href="?id=<?= $usuario['idusuario'] ?>">Borrar</a>
                                <a class="btn btn-primary " href="editar.php?id=<?= $usuario['idusuario'] ?>">Editar</a></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
            ?>
        </div>
    </body>
</html>
