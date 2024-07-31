<?php
use Cruz\Eduardo\Ciudad;
require_once "./clases/Ciudad.php"; 

// POST los valores: nombre, poblacion, pais y foto

$nombre = $_POST["nombre"] ;
$poblacion = $_POST["poblacion"];
$pais = $_POST["pais"];
$foto = $_FILES["foto"];

$retorno = new stdClass();
$retorno->exito = false;
$retorno->mensaje = "";


if($nombre !== NULL && $poblacion !== NULL & $pais !== NULL){

    $cuidad = new Ciudad("",$nombre,$poblacion,$pais,"");

    if ($cuidad->existe(Ciudad::traer())) {
        # code...
        $retorno->mensaje = "La ciudad ya existe en la base de datos";
    }
    else{
        // agregar
         // Procesar la imagen
        $timestamp = date("His");
        $extension = pathinfo($foto["name"], PATHINFO_EXTENSION);
        $fotoNombre = $nombre . ".". $pais. ".". $timestamp . "." . $extension;
        $directorio = "./ciudades/imagenes/";
        $rutaDestino = $directorio . $fotoNombre;

        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }

        if (move_uploaded_file($foto["tmp_name"], $rutaDestino)) {

            $cuidadConFoto = new Ciudad(0,$nombre,$poblacion,$pais,$fotoNombre);
            
            // Intentar agregar el neumático a la base de datos
            if ($cuidadConFoto->agregar()) {
                $retorno->exito = true;
                $retorno->mensaje = "cuidad agregado exitosamente.";
            } else {
                $retorno->mensaje = "Error al agregar el neumático a la base de datos.";
            }

        } else {
            $retorno->mensaje = "Error al subir la imagen.";
        }
    }
    echo json_encode($retorno);
}

?>