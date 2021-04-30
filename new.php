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

// Si no existe el boton nos manda para atras
if (!isset($_POST['newEnlaces']) && !isset($_POST['enviar']) ) {
   
     header('location:index.php'); 
    
}

// Si el usuario es el invitado nos manda atras

if ($_SESSION['usuario'] == 'invitado') {
    header('location:index.php');
}





$procesaFormulario = false;
$claseError = "";
$msgError = "";
$enlace = "";
$descripcion = "";

if (isset($_POST['enviar'])) {
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
    <h2>New bookMark</h2>
    <?php

    include("include/form_newbm.php");

    ?>


    
</body>

</html>
