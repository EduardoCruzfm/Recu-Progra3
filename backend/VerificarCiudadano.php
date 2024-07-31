<?php
use Cruz\Eduardo\Ciudadano;
require_once "./clases/Ciudadano.php"; 

$email = $_POST["email"];
$clave = $_POST["clave"];

$path = "./archivos/ciudadanos.json";


if($email !== NULL & $clave !== NULL) {

    $ciudadano = new Ciudadano("",$email,$clave);
    $respuesta = $ciudadano->verificarExistencia($ciudadano, $path);

    echo json_encode($respuesta);
}


?>