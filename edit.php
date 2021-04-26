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

// Si no existe el id nos manda para atras
if (!isset($_GET['id'])) {
    header('location:index.php');
}

// Si el usuario es el invitado nos manda atras

if ($_SESSION['usuario'] == 'invitado') {
    header('location:index.php');
}

// traer el marcador completo
$marcadores = $enlaces->get($_GET['id']);

// si el id de usuario es distinto del id del marcador de ese usuario nos lleva hacia atras

if ($_SESSION['idUsuario'] != $marcadores[0]['idUsuario']) {
    header('location:index.php');
}


$enlace = $marcadores[0]['enlace'];
$descripcion = $marcadores[0]['descripcion'];
$id = $marcadores[0]['id'];


$procesaFormulario = false;
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
}
if ($procesaFormulario) {
   
    $enlaces->setDescripcion($descripcion);
    $enlaces->setEnlace($enlace);
    $enlaces->edit($_GET['id']);

   header('location:index.php');
    
}



?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>MARCADORES</h1>
    <h2>edit bookMark</h2>
    <?php

    include("include/form_editbm.php");

    ?>


    <a href="cerrarSesion.php">Cerrar Sesion</a>

</body>

</html>