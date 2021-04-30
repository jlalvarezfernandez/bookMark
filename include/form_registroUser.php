<?php
echo "<form action=\"registroUser.php\" method=\"POST\">";

echo "<br>";
echo "<label for=\"usuario\">Usuario: <input type=\"text\" name=\"usuario\" value=\"" . $usuario . "\"></label>";
echo "<span class=\"" . $claseError . "\">" . $msgError . "</span>";
echo "<br>";
echo "<br>";
echo "<label for=\"contraseña\">Contraseña: <input type=\"text\" name=\"pass1\" value=\"" . $pass1 . "\"></label>";
echo "<span class=\"" . $claseError . "\">" . $msgError . "</span>";
echo "<br>";
echo "<br>";
echo "<label for=\"contraseña\">Contraseña: <input type=\"text\" name=\"pass2\" value=\"" . $pass2 . "\"></label>";
echo "<span class=\"" . $claseError . "\">" . $msgError . "</span>";
echo "<br>";
echo "<br>";
echo "<input type=\"submit\" name= \"enviar\" value=\"Enviar\">";
echo "<br>";
echo "</form>";


echo "<br>";
