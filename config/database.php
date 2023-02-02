<?php
function conectarDB() : mysqli {
// conectara una base de datos

// localhost se refiere a la computadora donde esta alojado el proyecto
// root es el usuario 
// el 2do root es el password
$db = mysqli_connect('localhost', 'root', '', 'bienes_raices');

$db->set_charset("utf8");// le digo que $db va a tener codificación de caracteres utf8 para los acentos y Ñ
// este if es para saber su la conexion a la base funciona
// sino funciona va a tirar un Fatal error
if (!$db) {
    echo "no se conecto";   // se comenta para que no se refreje en pantalla solo como prueba
exit;
}
return $db;
}


