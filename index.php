<?php

include("Model/Usuarios.php");
include("Model/Marcadores.php");
include_once("Model/config.php");
include_once("include/funciones.php");

session_start();

$nombre = "";
$pass = "";
$perfil = [];



$user = Usuarios::getInstancia();
$enlaces = Marcadores::getInstancia();

if (!isset($_SESSION['usuario'])) {
    $_SESSION['usuario'] = "invitado";
    $_SESSION['perfil'] = "invitado";
    $_SESSION['idUsuario'] = "";
}


if (!isset($_POST['enviar'])) {
    $nombre = $_POST['nombre'] ?? ""; // si existe lo pone a $post si no no
    $pass = $_POST['pass'] ?? "";

    $perfil = $user->login($nombre, $pass);
    if ($perfil['usuario'] != 'invitado') {
        $_SESSION['usuario'] = $perfil['usuario'];
        $_SESSION['perfil'] = $perfil['perfil'];
        $_SESSION['idUsuario'] = $perfil['id'];


        $listaEnlaces = $enlaces->getMarcadoresPorUsuario($perfil['id']);
    } else {
    }
}

if (!isset($_POST['marcarTodos'])) {
}

// declaracion de variables
$procesaFormulario = false;
$enlace = "";
$descripcion = "";
$claseError = "";
$msgError = "";




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <h1>MARCADORES</h1>
    <?php
    echo "<h3>Usted está en el sistema como " . $_SESSION['usuario'] . "</h3>";


    if ($_SESSION['perfil'] == 'invitado') {
        echo "<form action=\"\" method=\"post\">";
        echo "<label for=\"nombre\"><input type=\"text\" name=\"nombre\"></label>";
        echo "<br>";
        echo "<label for=\"pass\"><input type=\"text\" name=\"pass\"></label>";
        echo "<br>";
        echo "<input type=\"submit\" value=\"enviar\">";
        echo "</form>";
        echo "No tienes cuenta?";
        echo "<a href=\"registroUser.php\">REGISTRATE</a>";
    } else {
        if ($_SESSION['perfil'] == 'bloqueado') {
            echo "estas bloqueado";
            echo "<br>";
            echo "Ponte en contacto con el administrador";
            echo "<br>";
            echo "<a href=\"cerrarSesion.php\"><h3>Volver</h3></a>";
        } else {
            if ($_SESSION['perfil'] == 'admin') {
                $listaUsuarios = $user->usersBloqueados();
                echo "Accion Administrador";
                echo "<br>";
                echo "<br>";
                if (count($listaUsuarios) == 0) {
                    echo "Ninguna solicitud de admisión pendiente";
                } else {
                    $estado = "DESMARCAR";
                    $checked = "checked";
                    
                    if (isset($_POST['seleccionar'])) {
                        if ($_POST['seleccionar'] == "DESMARCAR") {
                            $checked = "";
                            $estado = "MARCAR";
                        } else {
                            $estado = "DESMARCAR";
                            $checked = "checked";
                        }
                    }
                if (isset($_POST['validar'])) {
                    foreach ($_POST['usuario'] as $valor) {
                       $user->activarUsuarios($valor);
                   } 
                   header("location:index.php");

                }
                    echo "<form action=\"index.php\" method=\"post\">";
                    echo "<input type=\"submit\" name=\"seleccionar\" value=\"" . $estado . "\">";
                    echo "<br>";
                    echo "<br>";
                    foreach ($listaUsuarios as $valor) {
                        //echo "<input type=\"checkbox\" name=\"" . $valor['id'] . "\" value=\"" . $valor['id'] . "\" " . $checked . ">" . $valor['usuario'] . "<br>";
                        echo "<input type=\"checkbox\" name=\"usuario[]\" value=\"" . $valor['id'] . "\" " . $checked . ">" . $valor['usuario'] . "<br>";
                    }
                    echo "<br>";

                    echo "<input type=\"submit\" name=\"validar\" value=\"VALIDAR\">";

                    echo "</form>";
                }




                echo "<a href=\"cerrarSesion.php\"><h3>Volver</h3></a>";
            } else {
                echo "<form action=\"new.php\" method=\"post\">";
                echo "<input type=\"submit\" name= \"newEnlaces\" value=\"Nuevo\">";
                echo "</form>";
                echo "<br>";
                echo "<br>";
                echo "<form action=\"\" method=\"post\">";
                echo "<input type=\"submit\" name=\"busqueda\" value=\"Busqueda \">";
                echo "<input type=\"text\" name=\"busquedaEnlace\" placeholder=\"busqueda de enlace\">";
                echo "</form>";

                echo "<br>";
                echo "<br>";

                if (!isset($_POST['busqueda'])) {
                    $listaEnlaces = $enlaces->getMarcadoresPorUsuario($_SESSION['idUsuario']);
                    echo "<br>";
                    echo "<table>";
                    echo "<tr><td> Enlace </td> <td>  Editar </td> <td>  Borrar</td> </tr>";
                    foreach ($listaEnlaces as $clave => $valor) {

                        $accionEdit = "<a href=\"edit.php?id=" . $valor['id'] . "\">EDIT</a>";

                        $accionDelete = "<a href=\"delete.php?id=" . $valor['id'] . "\">DELETE</a>";

                        echo "<tr>";
                        echo "<td>";
                        echo "<a href=\"" . $valor['enlace'] . "\" target=\"_blank\">" . $valor['descripcion'] . "</a><td> " . $accionEdit . "</td><td> " . $accionDelete . "</td>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "<a href=\"cerrarSesion.php\"><h3>Salir</h3></a>";
                } else {
                    $busqueda = $enlaces->getBusquedaByDescripcion($_POST['busquedaEnlace']);

                    // var_dump($busqueda);
                    echo "<table>";
                    echo "<tr>";
                    echo "<td>id</td>";
                    echo "<td>descripcion</td>";
                    echo "<td>enlace</td>";
                    echo "</tr>";
                    foreach ($busqueda as $clave => $valor) {
                        echo "<td>" . $valor['id'] . "</td>";
                        echo "<td>" . $valor['descripcion'] . "</td>";
                        echo "<td><a href=" . $valor['enlace'] . ">" . $valor['enlace'] . "</a></td>";
                    }
                    echo "<a href=\"cerrarSesion.php\"><h3>Salir</h3></a>";
                }
            }
        }
    }



    ?>




</body>

</html>

<!-- //SELECT enlace FROM `marcadores` group by enlace HAVING COUNT(*) >=3 -->