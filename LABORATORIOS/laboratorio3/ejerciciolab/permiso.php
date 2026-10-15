<?php
// Integrantes: Julian Joan Alexander
//              Jimenez Amachuy Franco Milton
// Se incluye DESPUES de proteger.php
if ($_SESSION["rol"] != "admin") {
    $_SESSION["mensaje"] = "Su rol (" . $_SESSION["rol"] . ") no tiene permiso para realizar esa accion.";
    $_SESSION["tipo"] = "error";
    header("Location: listar.php");
    exit();
}