<?php
use Cruz\Eduardo\Ciudad;
require_once "./clases/Ciudad.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $tabla = Ciudad::MostrarModificadas();

    echo $tabla;



}

?>