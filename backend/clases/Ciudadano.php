<?php
namespace Cruz\Eduardo;
    use stdClass;


    class Ciudadano { 
        public $ciudad;
        public $email;
        public $clave;
    
        public function __construct($ciudad = '', $email, $clave) {
            $this->ciudad = $ciudad;
            $this->email = $email;
            $this->clave = $clave;
        }
    
        public function toJSON() {
            $retorno = '{"ciudad" : "' . $this->ciudad . '", "email" : "' . $this->email . '", "clave" : ' . $this->clave . '}';
            return $retorno;
        }

        public function guardarEnArchivo($path){

            $retorno = new stdClass();
            $retorno->exito = false;
            $retorno->mensaje = "error guardar el archivo";

            $archivo = fopen($path,"a");

            $caracteresEscritos = fwrite($archivo ,$this->ToJSON() . "\r\n");

            if ($caracteresEscritos > 0) {
                $retorno->exito = true;
                $retorno->mensaje = "exito al guardar el archivo";
            }

            fclose($archivo);
            
            return $retorno;
        }


        public static function traerTodos($path):array{
            $texto = "";
            $array_respuesta = array();
            $archivo = fopen($path,"r");
            
            if ($archivo !== false) {
                
                while (!feof($archivo)) {        
                    $texto .= fgetc($archivo);
                }
                
                
                $obj_array = explode("\r\n",$texto);
                fclose($archivo);
                
                foreach($obj_array as $item){
                    
                    if ($item !== "") {
                        $obj = json_decode($item);
                        
                        $neumatico = new Ciudadano($obj->ciudad, $obj->email, $obj->clave);
    
                        array_push($array_respuesta,$neumatico);
                    }
                }
            }
    
            return $array_respuesta;
        }

        
        public function  verificarExistencia($ciudadano, $path) {
            $retorno = new stdClass();
            $retorno->exito = false;
            $retorno->mensaje = "El Ciudadano no esta registrado!";

            $listaCiudadanos = Ciudadano::traerTodos($path);

            foreach ($listaCiudadanos as $c) {
                
                if ($ciudadano->email == $c->email && $ciudadano->clave == $c->clave ) {
                    $retorno->exito = true;
                    $retorno->mensaje = "El Ciudadano ya esta registrado!";
                    break;
                }
            }

            return $retorno;
        }
    }




?>