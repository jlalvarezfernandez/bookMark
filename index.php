<?php

include("Model/Usuarios.php");
include("Model/Marcadores.php");
include_once("Model/config.php");

session_start();

$nombre = "";
$pass = "";
$perfil= [];



$user = Usuarios::getInstancia();
$enlaces = Marcadores::getInstancia();

if (!isset($_SESSION['usuario'])) {
    $_SESSION['usuario'] = "invitado";
}

if (!isset($_SESSION['idUsuario'])) {
    $_SESSION['idUsuario'] = "";
}

if (!isset($_POST['enviar'])) {
    $nombre = $_POST['nombre'] ?? ""; // si existe lo pone a $post si no no
    $pass = $_POST['pass'] ?? "";

    $perfil = $user->login($nombre, $pass);
    if ($perfil['usuario'] != 'invitado') {
        $_SESSION['usuario'] = $perfil['usuario'];
        $_SESSION['idUsuario'] = $perfil['id'];
     

        $listaEnlaces = $enlaces->getMarcadoresPorUsuario($perfil['id']);
      
    } else {
      

    }
}

// Funcion limpiar datos de entrada

function limpiarDatos($datos)
{
    $datos = trim($datos);
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos);
    return $datos;
}

// declaracion de variables
$procesaFormulario = false;
$enlace = "";
$descripcion = "";
$claseError = "";
$msgError = "";

if (isset($_POST['enviarEnlaces'])) {

    $procesaFormulario = true;
    $enlace = limpiarDatos($_POST['enlace']);
    $descripcion = limpiarDatos($_POST['descripcion']);
    if (empty($enlace)) {
        $msgError = "el campo no puede estar vacio";
        $claseError = "clase_error";
        $procesFormulario = false;
    }
    if (empty($descripcion)) {
        $msgError = "el campo no puede estar vacio";
        $claseError = "clase_error";
        $procesaFormulario = false;
    }
    $enlaces->setDescripcion($descripcion);
    $enlaces->setEnlace($enlace);
    $enlaces->setIdUsuario($_SESSION['idUsuario']);
    $enlaces->set(); 

}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>MARCADORES</h1>
    <?php

    if ($_SESSION['usuario'] == 'invitado') {
        echo "<form action=\"\" method=\"post\">";
        echo "<label for=\"nombre\"><input type=\"text\" name=\"nombre\"></label>";
        echo "<br>";
        echo "<label for=\"pass\"><input type=\"text\" name=\"pass\"></label>";
        echo "<br>";
        echo "<input type=\"submit\" value=\"enviar\">";
        echo "</form>";
    } else {
        echo "<form action=\"index.php\" method=\"POST\">";
        echo "<label for=\"enlace\">Nombre enlace: <input type=\"text\" name=\"enlace\" value=\"" . $enlace . "\"></label>";
        echo "<span class=\"" . $claseError . "\">" . $msgError . "</span>";
        echo "<br>";
        echo "<label for=\"descripcion\">Descripcion: <input type=\"text\" name=\"descripcion\" value=\"" . $descripcion . "\" size=100></label>";
        echo "<span class=\"" . $claseError . "\">" . $msgError . "</span>";
        echo "<br>";
        echo "<input type=\"submit\" value=\"Añadir Enlace\" name=\"enviarEnlaces\">";
        echo "</form>";
        echo "Lista de enlaces";
        echo "<br>";


  $listaEnlaces = $enlaces->getMarcadoresPorUsuario($_SESSION['idUsuario']);

        foreach ($listaEnlaces as $clave => $valor) {
            echo $valor['enlace'] . ": " . $valor['descripcion'] . "<br>";
        }
        
    }

    ?>



    <a href="cerrarSesion.php">Cerrar Sesion</a>

</body>

</html>