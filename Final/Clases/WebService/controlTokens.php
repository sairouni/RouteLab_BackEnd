<?php //Los JSON Web Tokens están formados por encabezado , contenido y una firma.
function jwtGetCodeJSON($contenido){
//El encabezado identifica el algoritmo usado para generar la firma:
$header = base64_encode(json_encode(array('alg' => 'HS256', 'typ' => 'JWT')) );
//El payload contiene la información de los privilegios token.
$payload = base64_encode($contenido);
//La clave ha de ser secreta, y se utiliza para generar la firma.
$secret_key = 'clave secreta';
//La firma se calcula codificando el encabezamiento y el contenido en base64url y concatenandolas con un punto
$signature = base64_encode(hash_hmac('sha256', $header . '.' . $payload, $secret_key, true));
//En el token, las tres partes -encabezado, contenido y firma- están concatenadas utilizando puntos de la siguiente forma:
$jwt_token = $header . '.' . $payload . '.' . $signature;
return $jwt_token;
}
// PARA VERIFICAR UN TOKEN
function jwtCheckCodeJSON($jwt_token){
$secret_key = 'clave secreta';
$jwt_values = explode('.', $jwt_token);
// podemos extraer el encabezado, el contenido y la signatura.
$header =$jwt_values[0] ;
$payload = $jwt_values[1];
$signature = $jwt_values[2];
$resultedsignature = base64_encode(hash_hmac('sha256', $header . '.' . $payload , $secret_key, true));
// checking if the created signature is equal to the received signature
if($resultedsignature == $signature) { return true; } else { return false; }
}
