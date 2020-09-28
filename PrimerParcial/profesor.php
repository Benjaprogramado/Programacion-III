<?php
require_once './filemanager.php';

class Profesor extends FileManager{
    public $_legajo;
    public $_nombre;

    public function __construct($_legajo,$nombre){
        $this->_legajo = $_legajo;
        $this->_nombre = $nombre;

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
        return $this->_legajo . '*' . $this->_nombre.PHP_EOL;
    }

    public static function saveProfeJson($dato)
    {
        $listaDatos= Profesor::readProfeJson();
        array_push($listaDatos, $dato);
        try {
            FileManager::saveJson("profesores.json", $listaDatos);
            return true;
        } catch (Exception $e) {
            echo ("Error al escribir archivo en formato json");
            return false;
        }
    }

    public static function readProfeJson()
    {
        try {
            $lista = FileManager::readJson("./profesores.json");
            return $lista;
        } catch (Exception $e) {
            echo ("Error al leer archivo en formato json");
            return false;
        }
    }

    public static function verificarProfesor($legajo)
    {
        $aux=false;
        $listaDatos = Profesor::readProfeJson();
        if (empty($listaDatos)) {
            echo "NO HAY PROFESORES CARGADOS";
            return false;
        }else{
            foreach($listaDatos as $value){
                if($value->_legajo==$legajo){
                    $aux=true;
                    return true;
                }
            }
        }
        if($aux == false){
            echo"PROFESOR INEXISTENTE";
        }
    }


}