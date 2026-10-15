<?php
// Integrantes:Julian Joan Alexander
//             Jimenez Amachuy Franco Milton
require_once "proteger.php";
require_once "permiso.php";
require_once "conexion.php";
require_once "funciones.php";

$nombres   = trim($_POST["nombres"]);
$apellidos = trim($_POST["apellidos"]);
$ci        = trim($_POST["ci"]);
$telefono  = trim($_POST["telefono"]);
$fecha     = $_POST["fecha_nacimiento"];

$foto = subirFotografia("fotografia");
if (substr($foto, 0, 5) == "ERROR") {
    $_SESSION["mensaje"] = $foto;
    $_SESSION["tipo"] = "error";
    header("Location: form_insertar.php");
    exit();
}

$sql = "INSERT INTO pacientes (fotografia, nombres, apellidos, ci, telefono, fecha_nacimiento)
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $foto, $nombres, $apellidos, $ci, $telefono, $fecha);
$stmt->execute();

$_SESSION["mensaje"] = "El paciente $nombres $apellidos se registro correctamente.";
header("Location: listar.php");
exit();