<?php
use Cruz\Eduardo\Ciudad;
require_once "./clases/Ciudad.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $response = new stdClass();
    $response->mensaje = "";
    
    if (isset($_GET["nombre"])){
        
        // Si el parámetro 'nombre' está presente en la URL
        $nombre = $_GET["nombre"];
        
        $cuidades = Ciudad::traer();

        foreach ($cuidades as $c) {;
            if ($c->nombre == $nombre) {
                $response->mensaje = "Existe la cuidad en la Base de Datos.";
                break;
            }
            else{
                $response->mensaje = "No existe la cuidad en la Base de Datos.";
            }
        }

        echo json_encode($response);

    }
    else{
        $archivoCiudadesBorradas = './archivos/ciudades_borradas.txt';

        if (file_exists($archivoCiudadesBorradas)) {
            $contenidoArchivo = file_get_contents($archivoCiudadesBorradas);
         
        $dir = "./ciudades/imagenes/";    
        echo '<table border="1">';
        echo '<tr><th>id</th><th>nombre</th><th>poblacion</th><th>pais</th><th>pathFoto</th></tr>';

        $lineas = explode("\n", $contenidoArchivo);

            foreach ($lineas as $linea) {
                $ciudad = json_decode($linea);
                // echo json_encode($ciudad);

                if ($ciudad !== null) {
            
            
                     
                echo '<tr>';
                echo '<td>' . $ciudad->id . '</td>';
                echo '<td>' . $ciudad->nombre . '</td>';
                echo '<td>' . $ciudad->poblacion . '</td>';
                echo '<td>' . $ciudad->pais . '</td>';
                echo '<td><img src="' . htmlspecialchars($dir . $ciudad->pathFoto ) . '" alt="Foto" width="50" height="50"></td>';
                echo '</tr>';
            
            }
        }
        echo '</table>';
            
        }
    }
}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') { //accion

    $response = new stdClass();
    $response->exito = null;
    $response->mensaje = "";

    // {"id" : 9 , "nombre" : "Lanus" ,"poblacion":1234, "pais" : "Argentina","pathFoto" : "Lanus.1234.174202.jpg"}
    if (isset($_POST["ciudad_json"])){

        $ciudad_json = $_POST["ciudad_json"]; // id, nombre, poblacion, pais y pathFoto
        $ciudad = json_decode($ciudad_json); 

        $id = $ciudad->id;
        $nombre = $ciudad->nombre;
        $poblacion = $ciudad->poblacion;
        $pais = $ciudad->pais;
        $pathFoto = $ciudad->pathFoto;

        $cuidadDelete = new Ciudad($id,$nombre,$poblacion,$pais,$pathFoto);
        

        if (isset($_POST["accion"]) && $_POST["accion"] == "borrar"){
            //eliminar   guardarEnArchivo
            $cuidadDelete->eliminar();
            Ciudad::guardarEnArchivo($cuidadDelete);
            
            $response->exito = true;
            $response->mensaje = "Exito al eliminar";
        }
        else{
            $response->exito = false;
            $response->mensaje = "No se recibio el parametro accion / Error al eliminar";
        }

    }
    echo json_encode($response);

}
?>