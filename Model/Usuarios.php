<?php

require_once('DBAbstractModel.php');

class Usuarios extends DBAbstractModel
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
    private $usuario;
    private $password;
    private $perfil;
    private $activo;
    private $created_at;
    private $updated_at;

    // Hacemos getters y setters

    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPerfil($perfil)
    {
        $this->perfil = $perfil;
    }

    public function getPerfil()
    {
        return $this->perfil;
    }

    public function setActivo($activo)
    {
        $this->activo = $activo;
    }

    public function getActivo()
    {
        return $this->activo;
    }



    // Hacemos los metodos del CRUD (create o set, read o get, update o edit, delete)

    // metodo set o create
    public function set()
    {
        $this->query = "INSERT INTO usuarios(usuario, password, perfil, activo) VALUES (:usuario, :password, :perfil, :activo)";

        $this->parametros['usuario'] = $this->usuario;
        $this->parametros['password'] = $this->password;
        $this->parametros['perfil'] = $this->perfil;
        $this->parametros['activo'] = $this->activo;
        $this->get_results_from_query();
        $this->mensaje = "Usuario añadido ";
    }

    // metodo get o read
    //necesitamos parametro siempre 
    public function get($id = '')
    {
        // si el id no esta vacio se hace la consulta
        if ($id != "") {
            $this->query = "SELECT * FROM usuarios WHERE id = :id";
            // cargamos los parametros
            $this->parametros['id'] = $id;

            //Ejecutamos la consulta que devuelve registros
            $this->get_results_from_query();
        }
        if (count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad => $value) {
                $this->$propiedad = $value;
            }
            $this->mensaje = "Usuario encontrado";
        } else {
            $this->mensaje = "Usuario no encontrado";
        }
        return $this->rows;
    }

    // Método update o edit

    public function edit($id = '')
    {
        $this->query = "UPDATE usuarios SET usuario=:usuario, password=:password WHERE id=:id";
        $this->parametros['usuarios'] = $this->usuarios;
        $this->parametros['password'] = $this->password;
        $this->parametros['id'] = $id;

        $this->get_results_from_query();
        $this->mensaje = "Usuario modificado";
    }

    //Médodo delete

    public function delete($id = '')
    {
        $this->query = "DELETE FROM usuarios WHERE id=:id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = "Usuario ELIMINADO";
    }

    //Método validar usuarios

    public function login($user, $pass)
    {
        $datosLogin = array();

        $this->query = "SELECT * FROM usuarios WHERE usuario=:usuario and password=:password";
        $this->parametros['usuario'] = $user;
        $this->parametros['password'] = $pass;
        $this->get_results_from_query();
        //autenticacion
        if (count($this->rows) == 1) {
            $datosLogin["usuario"] = $this->rows[0]['usuario'];
            $datosLogin["id"] = $this->rows[0]['id'];
            $datosLogin["perfil"] = $this->rows[0]['perfil'];
            //activo
            if (!$this->rows[0]['activo']) {
                $datosLogin["perfil"] = "bloqueado";
            }
        } else {

            $datosLogin["usuario"] = "invitado";
        }
        return $datosLogin;
    }

    public function usersBloqueados(){
        $this->query = "SELECT * FROM usuarios WHERE activo=0";
        $this->get_results_from_query();
        $this->mensaje = "Usuario bloqueado";
        return $this->rows;
    }

    public function activarUsuarios($id){
        $this->query = "UPDATE usuarios SET activo=1 WHERE id=:id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = "Usuario activado";
        return $this->rows;
    }
}
