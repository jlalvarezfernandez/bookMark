<?php

echo "<form action=\"delete.php?id=".$id."\" method=\"POST\">";
echo "<label for=\"enlace\">Nombre enlace: <input type=\"text\" disabled name=\"enlace\" value=\"" . $enlace . "\"></label>";
echo "<br>";
echo "<label for=\"descripcion\">Descripcion: <input type=\"text\" disabled name=\"descripcion\" value=\"" . $descripcion . "\" size=100></label>";
echo "<br>";
echo "<input type=\"submit\" value=\"Confirmar\" name=\"confirmarBorrado\">";
echo "<input type=\"submit\" value=\"Cancelar\" name=\"cancelarBorrado\">";
echo "</form>";
?>