<?php
require_once './filemanager.php';

class Asignacion extends FileManager{
    public $_legajo;
    public $_id;
    public $_turno;

    public function __construct($legajo,$id,$turno){
        $this->_legajo = $legajo;
        $this->_id = $id;
        $this->_turno = $turno;

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
        return $this->_legajo . '*' . $this->_id . '*' . $this->_turno . PHP_EOL;
    }

    public static function saveAsignacionJson($dato)
    {
        $listaDatos= Asignacion::readAsignacionJson();
        array_push($listaDatos, $dato);
        try {
            FileManager::saveJson("materias-profesores.json", $listaDatos);
            return true;
        } catch (Exception $e) {
            echo ("Error al escribir archivo en formato json");
            return false;
        }
    }

    public static function readAsignacionJson()
    {
        try {
            $lista = FileManager::readJson("./materias-profesores.json");
            return $lista;
        } catch (Exception $e) {
            echo ("Error al leer archivo en formato json");
            return false;
        }
    }


}