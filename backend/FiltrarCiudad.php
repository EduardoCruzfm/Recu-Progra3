<?php
use Cruz\Eduardo\Ciudad;
require_once "./clases/Ciudad.php";

$cuidades = Ciudad::traer();

if (isset($_POST["nombre"])){

    // Si el parámetro 'nombre' está presente en la URL
    $nombre = $_POST["nombre"];


    echo '<table border="1">';
    echo '<tr><th>id</th><th>nombre</th><th>poblacion</th><th>pais</th><th>pathFoto</th></tr>';

    foreach ($cuidades as $c) {
        if ($c->nombre == $nombre) {
                     
                echo '<tr>';
                echo '<td>' . $c->id . '</td>';
                echo '<td>' . $c->nombre . '</td>';
                echo '<td>' . $c->poblacion . '</td>';
                echo '<td>' . $c->pais . '</td>'; 
                echo '<td><img src="./ciudades/imagenes/' . $c->pathFoto . '" alt="Foto" width="50" height="50"></td>';
                echo '</tr>';
            
                echo '</table>';

        }
    }

}
elseif(isset($_POST["pais"])){

    // Si el parámetro 'nombre' está presente en la URL
    $pais = $_POST["pais"];

    // $cuidades = Ciudad::traer();
    echo '<table border="1">';
    echo '<tr><th>id</th><th>nombre</th><th>poblacion</th><th>pais</th><th>pathFoto</th></tr>';

    foreach ($cuidades as $c) {
        if ($c->pais == $pais) {
                     
                echo '<tr>';
                echo '<td>' . $c->id . '</td>';
                echo '<td>' . $c->nombre . '</td>';
                echo '<td>' . $c->poblacion . '</td>';
                echo '<td>' . $c->pais . '</td>';
                echo '<td><img src="./ciudades/imagenes/' . $c->pathFoto . '" alt="Foto" width="50" height="50"></td>';
                echo '</tr>';
            
                echo '</table>';

        }
    }

}
elseif(isset($_POST["pais"]) && isset($_POST["nombre"])){

    // Si el parámetro 'nombre' está presente en la URL
    $pais = $_POST["pais"];
    $nombre = $_POST["nombre"];


    // $cuidades = Ciudad::traer();
    echo '<table border="1">';
    echo '<tr><th>id</th><th>nombre</th><th>poblacion</th><th>pais</th><th>pathFoto</th></tr>';

    foreach ($cuidades as $c) {
        if ($c->pais == $pais && $c->nombre == $nombre) {
                     
                echo '<tr>';
                echo '<td>' . $c->id . '</td>';
                echo '<td>' . $c->nombre . '</td>';
                echo '<td>' . $c->poblacion . '</td>';
                echo '<td>' . $c->pais . '</td>';
                echo '<td><img src="./ciudades/imagenes/' . $c->pathFoto . '" alt="Foto" width="50" height="50"></td>';
                echo '</tr>';
            
                echo '</table>';

        }
    }

}

?>