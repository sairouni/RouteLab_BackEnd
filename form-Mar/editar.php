<!DOCTYPE html>

<html><head>
        <meta name="viewport" content="initial-scale=1.0, width=device-width" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>
        <title>Mantenimiento Usuarios</title>
    </head>
    <body> <div class="container">
            <div class="jumbotron">
                <h1>Editar usuarios</h1>
            </div>
            <?php
            require_once 'DB.php';
            $usuario_t = new DB("usuario", "idusuario", "*", ["nombre", "password", "email", "edad", "localidad"]);
            try {



//Con esta línea indicamos que si hay algún error se trate como una excepción


                $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

                $nombre = filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_STRING);
                $localidad = filter_input(INPUT_POST, "localidad", FILTER_SANITIZE_STRING);
                $edad = filter_input(INPUT_POST, "edad", FILTER_VALIDATE_INT);
                $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
                $idusuario = filter_input(INPUT_POST, "idusuario", FILTER_VALIDATE_INT);
                $password = filter_input(INPUT_POST, "password");

                if (!empty($nombre) && !empty($email) && !empty($idusuario) && !empty($edad) && !empty($password) && !empty($localidad)) {
                    $usuario_t->update($idusuario, ['nombre' => $nombre, 'email' => $email, 'edad' => $edad, 'password' => $password, 'localidad' => $localidad]);
                    ?>
                    <div class="alert alert-success">
                        <strong>Correcto: </strong> Usuario editado .
                    </div>
        <?php
    }

    if (!empty($id)) {

        $usuario = $usuario_t->getbyId($id);
        if (!empty($usuario)) {
            ?>

                        <form method="POST">
                            <input type="hidden" class="form-control" id="idusuario" name="idusuario" value="<?= $usuario['idusuario'] ?>">
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $usuario['nombre'] ?>">
                            </div>

                            <div class="form-group">
                                <label for="nombre">Password:</label>
                                <input type="text" class="form-control" id="password" name="password" value="<?= $usuario['password'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="mail">Mail:</label>
                                <input type="text" class="form-control" id="email"  name="email" value="<?= $usuario['email'] ?>">
                            </div>

                            <div class="form-group">
                                <label for="mail">Edad:</label>
                                <input type="text" class="form-control" id="edad"  name="edad" value="<?= $usuario['edad'] ?>">
                            </div>


                            <div class="form-group">
                                <label for="mail">Localidad:</label>
                                <input type="text" class="form-control" id="localidad"  name="localidad" value="<?= $usuario['localidad'] ?>">
                            </div>




                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </form>
            <?php
        } else {
            ?><p>Usuario desconocido</p>
                        <?php
                    }
                } else {
                    ?><p>Falta el id</p>
                    <?php
                }
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
            ?>
        </div>
    </body>
</html>