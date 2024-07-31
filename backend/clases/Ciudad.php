<?php
namespace Cruz\Eduardo;
    use stdClass;
    require_once "IParte1.php"; 
    require_once "IParte2.php"; 
    require_once "accesoDatos.php"; 

    class Ciudad implements IParte1, IParte2{  //públicos (id, nombre, poblacion, pais y pathFoto)
        public $id;
        public $nombre;
        public $poblacion;
        public $pais;
        public $pathFoto;
    
        public function __construct($id = '', $nombre = '', $poblacion = '',$pais = '',$pathFoto = '') {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->poblacion = $poblacion;
            $this->pais = $pais;
            $this->pathFoto = $pathFoto;
        }
    
        public function toJSON() {
            return json_encode([
                'id' => $this->id,
                'nombre' => $this->nombre,
                'poblacion' => $this->poblacion,
                'pais' => $this->pais,
                'pathFoto' => $this->pathFoto
            ]);
        }

        public function agregar(){ 
            $objPDO = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objPDO->retornarConsulta("INSERT INTO ciudades (nombre, poblacion, pais, path_foto) 
            VALUES (:nombre, :poblacion, :pais, :path_foto)");


            $consulta->bindValue(':nombre', $this->nombre, \PDO::PARAM_STR);
            $consulta->bindValue(':poblacion', $this->poblacion, \PDO::PARAM_INT);
            $consulta->bindValue(':pais', $this->pais, \PDO::PARAM_STR);
            $consulta->bindValue(':path_foto', $this->pathFoto, \PDO::PARAM_STR);
            $consulta->execute();

            
            if($consulta->rowCount() == 1){
                return true;
            }

            return false;
        }
        
        
        public static function traer(){ // id, nombre, poblacion, pais, foto)
            $objPDO = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objPDO->retornarConsulta("SELECT id, nombre, poblacion, pais, path_foto FROM ciudades");
            $consulta->execute();

            $ciudades = [];

            while ($fila = $consulta->fetch(\PDO::FETCH_ASSOC)) {
                if ($fila['path_foto'] === NULL) {
                    $c = new Ciudad(
                        $fila['id'],
                        $fila['nombre'],
                        $fila['poblacion'],
                        $fila['pais'],
                        ''
                    );
                    array_push($ciudades, $c);
                }
                else{
                    $c = new Ciudad(
                        $fila['id'],
                        $fila['nombre'],
                        $fila['poblacion'],
                        $fila['pais'],
                        $fila['path_foto']
                    );
                    array_push($ciudades, $c);
                }
                
            }

            return $ciudades;
        }

        
        
        public function existe($ciudades){ // (comparar por nombre y país)
            $retorno = false;
            
            foreach ($ciudades as $c) {
                
                if ($this->nombre === $c->nombre && $this->pais === $c->pais ) {
                    $retorno = true;
                    break;
                }
            }
            return $retorno;
        }

        public function modificar(){
            $retorno = false;
            $objPDO = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objPDO->retornarConsulta("UPDATE ciudades 
                                                    SET nombre = :nombre, poblacion = :poblacion, pais = :pais, path_foto = :path_foto 
                                                    WHERE id = :id");


            $consulta->bindValue(':id', $this->id, \PDO::PARAM_INT);
            $consulta->bindValue(':nombre', $this->nombre, \PDO::PARAM_STR);
            $consulta->bindValue(':pais', $this->pais, \PDO::PARAM_STR);
            $consulta->bindValue(':poblacion', $this->poblacion, \PDO::PARAM_INT);
            $consulta->bindValue(':path_foto', $this->pathFoto, \PDO::PARAM_STR);

            $consulta->execute();

            
            if($consulta->rowCount() == 1){
                $retorno = true;
            }

            return $retorno;
        }

        public function eliminar(){ //nombre y pais
            $retorno = false;
        
            $objPDO = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objPDO->retornarConsulta("DELETE FROM ciudades WHERE nombre = :nombre AND pais = :pais");
            $consulta->bindParam(':nombre', $this->nombre, \PDO::PARAM_STR);
            $consulta->bindParam(':pais', $this->pais, \PDO::PARAM_STR);
            $consulta->execute();
            
            if($consulta->rowCount() == 1){
                $retorno = true;
            }
            
            return $retorno;
        }

        public static function guardarEnArchivo(Ciudad $ciudad){
            
            $retorno = new stdClass();
            $retorno->exito = false;
            $retorno->mensaje = "Error guardar el archivo";

            $path = "./archivos/ciudades_borradas.txt";

            $archivo = fopen($path,"a");

            $caracteresEscritos = fwrite($archivo ,$ciudad->toJSON() . "\r\n");

            if ($caracteresEscritos > 0) {
                $retorno->exito = true;
                $retorno->mensaje = "Exito al guardar el archivo";
            }

            fclose($archivo);
            
            return $retorno;
        }

        public static function MostrarModificadas() {

            $dir = "./ciudades/modificada/";
            $files = scandir($dir);
            $tableHTML = '<table border="1">';
            $tableHTML .= '<tr><th>Foto</th></tr>';
    
            foreach ($files as $file) {
    
                if ($file !== '.' && $file !== '..' && !is_dir($dir . $file)) {
                    $tableHTML .= '<tr>';
                    $tableHTML .= '<td><img src="' . htmlspecialchars($dir . $file) . '" alt="Foto" width="100" height="100"></td>';
                    $tableHTML .= '</tr>';
                }
            }
    
            $tableHTML .= '</table>';
            return $tableHTML;
        }


    }




?>