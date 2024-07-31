<?php
use Cruz\Eduardo\Ciudadano;
require_once "./clases/Ciudadano.php"; 



$path = "./archivos/ciudadanos.json";


if ($_SERVER['REQUEST_METHOD'] === 'GET')  {

    $respuesta = Ciudadano::traerTodos($path); // O iterar???

    echo json_encode($respuesta);
}


?>