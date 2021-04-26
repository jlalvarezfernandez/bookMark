<?php
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
    var_dump($_POST);
    exit;
    $enlaces->setDescripcion($descripcion);
    $enlaces->setEnlace($enlace);
    $enlaces->setIdUsuario($_SESSION['idUsuario']);
    $enlaces->edit($_GET['id']);

    header('location:index.php');
}