<?php
class Perfil
{
    private $idPerfil;
    private $nombre;
    private $descripcion;

    //constructor con array
    public function __construct($campo, $valor)
    {
        if ($campo != null) {
            if (!is_array($campo)) {
                $cadenaSQL = "SELECT idPerfil,nombre,descripcion FROM perfil WHERE $campo = $valor;";
                $campo = ConectorBD::ejecutarQuery($cadenaSQL)[0];
                print_r($campo);
            }
            //asignacion de los datos
            $this->idPerfil = $campo['idPerfil'];
            $this->nombre = $campo['nombre'];
            $this->descripcion = $campo['descripcion'];
        }
    }

    public function getIdPerfil($campo,$valor)
    {
        $cadenaSQL = "SELECT idPerfil FROM perfil WHERE $campo = '$valor';";
        $id = ConectorBD::ejecutarQuery($cadenaSQL);
        $this->idPerfil = $id;
        return $this->idPerfil;
    }

    // public function getIdPerfil()
    // {
    //     return $this->idPerfil;
    // }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    //set
    public function setIdPerfil($idPerfil)
    {
        $this->idPerfil = $idPerfil;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function guardar()
    {
        //echo $this->nombre, $this->descripcion;
        $cadenaSQL = "INSERT INTO  perfil (nombre, descripcion ) VALUES ('$this->nombre', '$this->descripcion')";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function modificar()
    {
        $cadenaSQL = "update perfil set nombre='{$this->nombre}', descripcion='{$this->descripcion}' where idPerfil= {$this->idPerfil}";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function eliminar()
    {
        $cadenaSQL = "DELETE FROM perfil WHERE idPerfil = $this->idPerfil;";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getLista($filtro, $orden)
    {
        if ($filtro == null || $filtro == '')
            $filtro = '';
        else
            $filtro = "where $filtro";
        if ($orden == null || $orden == '')
            $orden = '';
        else
            $orden = "order by $orden";

        $cadenaSQL = "SELECT idPerfil, nombre, descripcion FROM perfil $filtro $orden";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getListaEnObjetos($filtro, $orden)
    {
        $resultado = Perfil::getLista($filtro, $orden);
        $lista = array();
        for ($i = 0; $i < count($resultado); $i++) {
            $perfil = new Perfil($resultado[$i], null);
            $lista[$i] = $perfil;
        }
        return $lista;
    }
}