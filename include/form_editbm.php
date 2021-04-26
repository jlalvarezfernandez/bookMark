<?php

echo "<form action=\"edit.php?id=".$id."\" method=\"POST\">";
echo "<label for=\"enlace\">Nombre enlace: <input type=\"text\" name=\"enlace\" value=\"" . $enlace . "\"></label>";
echo "<br>";
echo "<label for=\"descripcion\">Descripcion: <input type=\"text\" name=\"descripcion\" value=\"" . $descripcion . "\" size=100></label>";
echo "<br>";
echo "<input type=\"submit\" value=\"Modificar Enlace\" name=\"enviarEnlaces\">";
echo "</form>";
?>