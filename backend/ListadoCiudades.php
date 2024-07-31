<?php
use Cruz\Eduardo\Ciudad;
require_once "./clases/Ciudad.php"; 

// $tabla = $_GET["tabla"] ;
$tabla = isset($_GET['tabla']) ? $_GET['tabla'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'GET')  {

    $cuidades = Ciudad::traer(); // O iterar???


    if (isset($_GET["tabla"]) && $_GET["tabla"] === "mostrar") {
        
        echo '<table border="1">';
        echo '<tr><th>id</th><th>nombre</th><th>poblacion</th><th>pais</th><th>pathFoto</th></tr>';

        foreach ($cuidades as $c) {
                        
                    echo '<tr>';
                    echo '<td>' . $c->id . '</td>';
                    echo '<td>' . $c->nombre . '</td>';
                    echo '<td>' . $c->poblacion . '</td>';
                    echo '<td>' . $c->pais . '</td>';
                    echo '<td><img src="./ciudades/imagenes/' . $c->pathFoto . '" alt="Foto" width="50" height="50"></td>';
                    echo '</tr>';
                
                    
                }
            echo '</table>';
    
    }
    elseif($tabla !== 'mostrar'){    
        echo json_encode($cuidades);
    }
}


?>