<?php
// Integrantes:  Julian Joan Alexander
//              Jimenez Amachuy Franco Milton
require_once "proteger.php";
require_once "permiso.php";
require_once "conexion.php";

$id = (int)$_GET["id"];

// primero ver si tiene citas
$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM citas WHERE paciente_id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$total = $stmt->get_result()->fetch_assoc()["total"];

if ($total > 0) {
    $_SESSION["mensaje"] = "No se puede eliminar: el paciente tiene $total cita(s) registrada(s).";
    $_SESSION["tipo"] = "error";
} else {
    $stmt = $conn->prepare("DELETE FROM pacientes WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $_SESSION["mensaje"] = "Paciente eliminado correctamente.";
}
header("Location: listar.php");
exit();