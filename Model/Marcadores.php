<?php

require_once('DBAbstractModel.php');

class Marcadores extends DBAbstractModel
{
    private static $instancia; // esto es el modelo singleton

    public static function getInstancia()
    {
        if (!isset(self::$instancia)) {
            $miClase = __CLASS__;
            self::$instancia = new $miClase;
        }
        return self::$instancia;
    }

    // Funcion clone para evitar que no se pueda clonar

    public function __clone()
    {
        trigger_error("La clonación no está permitida!", E_USER_ERROR);
    }

    // Atributos
    private $id;
    private $descripcion;
    private $enlace;
    private $idUsuario;
    private $created_at;
    private $updated_at;

    // Hacemos getters y setters

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setEnlace($enlace)
    {
        $this->enlace = $enlace;
    }

    public function getEnlace()
    {
        return $this->enlace;
    }

    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    // Hacemos los metodos del CRUD (create o set, read o get, update o edit, delete)

    // metodo set o create
    public function set()
    {
        $this->query = "INSERT INTO marcadores(descripcion, enlace, idUsuario) VALUES (:descripcion, :enlace, :idUsuario)";

        $this->parametros['descripcion'] = $this->descripcion;
        $this->parametros['enlace'] = $this->enlace;
        $this->parametros['idUsuario'] = $this->idUsuario;
        $this->get_results_from_query();
        $this->mensaje = "Marcador añadido ";
    }

    // metodo get o read
    //necesitamos parametro siempre 
    // getbyid
    public function get($id = '')
    {
        // si el id no esta vacio se hace la consulta
        if ($id != "") {
            $this->query = "SELECT * FROM marcadores WHERE id = :id";
            // cargamos los parametros
            $this->parametros['id'] = $id;

            //Ejecutamos la consulta que devuelve registros
            $this->get_results_from_query();
        }
        if (count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad => $value) {
                $this->$propiedad = $value;
            }
            $this->mensaje = "Marcador encontrado";
        } else {
            $this->mensaje = "Marcador no encontrado";
        }
        return $this->rows;
    }

    // Método update o edit

    public function edit($id = '')
    {
        $this->query = "UPDATE marcadores SET descripcion=:descripcion, enlace=:enlace WHERE id=:id";
        $this->parametros['descripcion'] = $this->descripcion;
        $this->parametros['enlace'] = $this->enlace;
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = "Marcador modificada";
    }

    //Médodo delete

    public function delete($id = '')
    {
        $this->query = "DELETE FROM marcadores WHERE id=:id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = "Marcador ELIMINADO";

    }

      // Método para sacar los marcadores por usuario

      public function getMarcadoresPorUsuario($idUsuario){

        $this->query = "SELECT * FROM marcadores WHERE idUsuario =:idUsuario";
        $this->parametros['idUsuario'] = $idUsuario;
        $this->get_results_from_query();
        $this->mensaje = "marcadores buscados por Usuario";
        return $this->rows;

    }

    // Método para buscar por descripcion y enlace

    public function getBusquedaByDescripcion($descripcion){

        $this->query = "SELECT * FROM marcadores WHERE descripcion =:descripcion";
        $this->parametros['descripcion'] = $descripcion;
        $this->get_results_from_query();
        $this->mensaje = "Marcador encontrado";
        return $this->rows;


    }









}
