<?php
require_once './filemanager.php';

class Precio extends FileManager
{
    public $_precio_hora;
    public $_precio_estadia;
    public $_precio_mensaual;

    public function __construct($precio_hora, $precio_estadia, $precio_mensual)
    {
        $this->_precio_hora = $precio_hora;
        $this->_precio_estadia = $precio_estadia;
        $this->_precio_mensual = $precio_mensual;
    }
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __toString()
    {
        return $this->_precio_hora . '*' . $this->_precio_estadia . '*' . $this->_precio_mensual . PHP_EOL;
        //return json_decode($this);
    }

    public static function savePrecioJson($dato)
    {
        $listaDatos = Precio::readPrecioJson();
        array_push($listaDatos, $dato);
        try {
            FileManager::saveJson("Precios.json", $listaDatos);
            return true;
        } catch (Exception $e) {
            echo ("Error al escribir archivo en formato json");
            return false;
        }
    }

    public static function readPrecioJson()
    {
        try {
            $lista = FileManager::readJson("./Precios.json");
            return $lista;
        } catch (Exception $e) {
            echo ("Error al leer archivo en formato json");
            return false;
        }
    }

    public static function verificarPrecio($precio_hora)
    {
        $aux=false;
        $listaDatos = Precio::readPrecioJson();
        if (empty($listaDatos)) {
            echo "NO HAY PrecioS CARGADAS";
            return false;
        }else{
            foreach($listaDatos as $value){
                if($value->_precio_hora==$precio_hora){
                    $aux=true;
                    return true;
                }
            }
        }
        if($aux == false){
            echo"Precio INEXISTENTE";
        }

    }
}
