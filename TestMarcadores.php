<?php
include("Model/Marcadores.php");
include_once("Model/config.php");

// Creamos una instancia del objeto palabra
$mark = Marcadores::getInstancia();

//PROBAMOS EL CREATE O SET
 $mark->setDescripcion("enlace pagina deportes");
 $mark->setEnlace("http://www.marca.es");
 $mark->setIdUsuario(1);
 $mark->set();

 $mark->setDescripcion("enlace pagina deportes");
 $mark->setEnlace("http://www.as.es");
 $mark->setIdUsuario(2);
 $mark->set();

// Hacemos la persistencia a la base de datos
 
 