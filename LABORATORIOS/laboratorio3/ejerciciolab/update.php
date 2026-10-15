<?php
// Integrantes: Julian Joan Alexander
//              Jimenez Amachuy Franco Milton
require_once "proteger.php";
require_once "permiso.php";
require_once "conexion.php";
require_once "funciones.php";

$id          = (int)$_POST["id"];
$nombres     = trim($_POST["nombres"]);
$apellidos   = trim($_POST["apellidos"]);
$ci          = trim($_POST["ci"]);
$telefono    = trim($_POST["telefono"]);
$fecha       = $_POST["fecha_nacimiento"];
$foto_actual = $_POST["foto_actual"];

$foto = subirFotografia("fotografia");
if (substr($foto, 0, 5) == "ERROR") {
    $_SESSION["mensaje"] = $foto;
    $_SESSION["tipo"] = "error";
    header("Location: form_editar.php?id=" . $id);
    exit();
}
// si no eligio foto nueva, se queda la anterior
if ($foto == "") {
    $foto = $foto_actual;
}

$sql = "UPDATE pacientes
        SET fotografia=?, nombres=?, apellidos=?, ci=?, telefono=?, fecha_nacimiento=?
        WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssi", $foto, $nombres, $apellidos, $ci, $telefono, $fecha, $id);
$stmt->execute();

$_SESSION["mensaje"] = "Paciente actualizado correctamente.";
header("Location: listar.php");
exit();