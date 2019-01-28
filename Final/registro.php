
<?php
require_once'usuario.php';
require_once'localidad.php';
require_once 'Post.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');


  $pasword = filter_input(INPUT_POST, "pass");
  $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);

$a = new usuario();
$a->nombreusuario = "marc_elcampeador";
$a->nombre = "marc";
$a->email = $email;
$a->nombre = "marquitus";
$a->fechanacimiento = '1920-02-10';
$a->pass = $pasword;
$a->foto = "jfiejfef";
$a->empresa = "1";
$a->nombre_empresa = "Stucom";
$c = new Localidad();
$c->load(1);
$a->localidad = $c;
print_r($c);
$a->save();

/*
  $b = new Post();
  $b->titulo="La travesia en Argentina";
  $b->descripcion=" en esta travesia seras bien chido";
  $b->tipo="ruta";
  $b->save();
  $d = new usuario();
  $d->load(4);
  $b->usuario=$d;
  print_r($d);
 */
?>
</body>
</html>
