<?php
// Integrantes: Julian Joan Alexander
//              Jimenez Amachuy Franco Milton
session_start();
require_once "conexion.php";

$correo = trim($_POST["correo"]);
$hash   = sha1($_POST["clave"]);

$sql = "SELECT id, correo, nombre, rol FROM usuarios WHERE correo=? AND clave=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $correo, $hash);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows == 1) {
    $u = $res->fetch_assoc();
    $_SESSION["id"]     = $u["id"];
    $_SESSION["correo"] = $u["correo"];
    $_SESSION["nombre"] = $u["nombre"];
    $_SESSION["rol"]    = $u["rol"];
    header("Location: panel.php");
    exit();
} else {
    header("Location: form_login.php?error=1");
    exit();
}