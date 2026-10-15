<?php
// Integrantes: Julian Joan Alexander
//              Jimenez Amachuy Franco Milton
$servidor = "localhost";
$usuario  = "root";
$clave    = "";
$bd       = "bd_consultorio26";
$puerto   = 3306;

$conn = new mysqli($servidor, $usuario, $clave, $bd, $puerto);

if ($conn->connect_error) {
    die("Error de conexion: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");