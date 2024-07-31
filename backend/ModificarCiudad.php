<?php

use Cruz\Eduardo\Ciudad;
require_once "./clases/Ciudad.php";

$ciudad_json = $_POST["ciudad_json"]; // id, nombre, poblacion, pais y pathFoto
$ciudad = json_decode($ciudad_json);

$id = $ciudad->id;
$nombre = $ciudad->nombre;
$poblacion = $ciudad->poblacion;
$pais = $ciudad->pais;
$pathFoto = $ciudad->pathFoto;

$foto = $_FILES["foto"];

$response = new stdClass();
$response->exito = false;
$response->mensaje = "Error al modificar";

// {"id" : 16 , "nombre" : "Cañuelas" ,"poblacion":5, "pais" : "Argentina","pathFoto" : "Cañuelas.Argentina.010903.jpg"}

$ciudadModif = new Ciudad($id, $nombre, $poblacion, $pais, $pathFoto);

if ($ciudadModif->modificar()) {
    $response->exito = true;
    $response->mensaje = "Éxito al modificar";

    $directorio_modif = "./ciudades/modificada/";

    // Verificar si el directorio de destino existe, si no, crearlo
    if (!is_dir($directorio_modif)) {
        mkdir($directorio_modif, 0777, true);
    }

    if (file_exists("./ciudades/imagenes/" . $pathFoto)) {
        // Intentar mover el archivo
        if (rename("./ciudades/imagenes/" . $pathFoto, $directorio_modif . $pathFoto)) {
            $response->mensaje = "El archivo se ha movido correctamente.";
        } else {
            $response->mensaje = "Error al mover el archivo.";
        }
    } else {
        $response->mensaje = "El archivo no existe en la ruta original.";
    }

    // Procesar la imagen
    $timestamp = date("His");
    $extension = pathinfo($foto["name"], PATHINFO_EXTENSION);
    $fotoNombre = $nombre . ".". $pais . ".". $timestamp . "." . $extension;
    $directorio = "./ciudades/imagenes/";
    $rutaDestino = $directorio . $fotoNombre;

    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }

    if (move_uploaded_file($foto["tmp_name"], $rutaDestino)) {
        $response->mensaje .= " Foto nueva movida correctamente.";
    } else {
        $response->mensaje .= " Error al mover la foto nueva.";
    }
}

echo json_encode($response);


?>
