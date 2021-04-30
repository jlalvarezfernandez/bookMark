<?php

include("Model/Usuarios.php");

include_once("Model/config.php");
include_once("include/funciones.php");


session_start();




$procesaFormulario = false;
$claseError = "";
$msgError = "";
$usuario = "";
$pass1 = "";
$pass2 = "";

if (isset($_POST['enviar'])) {
    $procesaFormulario = true;
    $usuario = limpiarDatos($_POST['usuario']);
    $pass1 = limpiarDatos($_POST['pass1']);
    $pass2 = limpiarDatos($_POST['pass2']);
    if (empty($usuario)) {
        $msgError = "el campo no puede estar vacio";
        $claseError = "clase_error";
        $procesaFormulario = false;
    }
    if (empty($pass1)) {
        $msgError = "el campo no puede estar vacio";
        $claseError = "clase_error";
        $procesaFormulario = false;
    }
    if (empty($pass2)) {
        $msgError = "el campo no puede estar vacio";
        $claseError = "clase_error";
        $procesaFormulario = false;
    }
    if ($pass1 != $pass2) {
        $msgError = "las contraseñas no coinciden";
        $claseError = "clase_error";
        $procesaFormulario = false;
    }

    if ($procesaFormulario) {
        $user = Usuarios::getInstancia();
        $user->setUsuario($usuario);
        $user->setPassword($pass1);
        $user->setPerfil('user');
        $user->setActivo(0);
        $user->set();
        header('location:index.php'); 
    }
    
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
    <h1>USUARIOS</h1>
    <h2>New Usuario</h2>
    <?php

    include("include/form_registroUser.php");

    ?>


    
</body>

</html>
