<?php

use Cruz\Eduardo\Ciudadano;

require_once "./clases/Ciudadano.php";

$ciudad = $_POST["ciudad"] ;
$email = $_POST["email"];
$clave = $_POST["clave"];

$path = "./archivos/ciudadanos.json";

if($ciudad !== NULL && $email !== NULL & $clave !== NULL) {

    $ciudadano = new Ciudadano($ciudad,$email,$clave);
    $respuesta = $ciudadano->guardarEnArchivo($path);

    echo json_encode($respuesta);
}