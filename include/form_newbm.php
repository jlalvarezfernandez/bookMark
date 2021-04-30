<?php
echo "<form action=\"new.php\" method=\"POST\">";

echo "<br>";
echo "<label for=\"enlace\">Nombre enlace: <input type=\"text\" name=\"enlace\" value=\"" . $enlace . "\"></label>";
echo "<span class=\"" . $claseError . "\">" . $msgError . "</span>";
echo "<br>";
echo "<br>";
echo "<label for=\"descripcion\">Descripcion: <input type=\"text\" name=\"descripcion\" value=\"" . $descripcion . "\" size=100></label>";
echo "<span class=\"" . $claseError . "\">" . $msgError . "</span>";
echo "<br>";
echo "<br>";
echo "<input type=\"submit\" name= \"enviar\" value=\"Enviar\">";
echo "<br>";
echo "</form>";


echo "<br>";
