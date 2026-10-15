<?php
// Integrantes:Julian Joan Alexander
//             Jimenez Amachuy Franco Milton
require_once "proteger.php";
require_once "conexion.php";

$pacientes  = $conn->query("SELECT COUNT(*) AS t FROM pacientes")->fetch_assoc()["t"];
$medicos    = $conn->query("SELECT COUNT(*) AS t FROM medicos")->fetch_assoc()["t"];
$pendientes = $conn->query("SELECT COUNT(*) AS t FROM citas WHERE estado='pendiente'")->fetch_assoc()["t"];

include "menu.php";
?>
<div class="contenedor">

<h2>Bienvenido/a, <?= htmlspecialchars($_SESSION["nombre"]) ?></h2>

<div class="panel">
    Correo: <strong><?= htmlspecialchars($_SESSION["correo"]) ?></strong>
    &nbsp;|&nbsp; Rol: <span class="etiqueta et-<?= $_SESSION["rol"] ?>"><?= $_SESSION["rol"] ?></span>
    <p style="font-size:11px;color:#5a6a7e;margin-bottom:0">
        Identificador de la sesion: <?= session_id() ?>
    </p>
</div>

<h2>Resumen del consultorio</h2>
<div class="tarjetas">
    <div class="tarjeta">
        <div class="numero"><?= $pacientes ?></div>
        <div class="texto">Pacientes registrados</div>
    </div>
    <div class="tarjeta">
        <div class="numero"><?= $medicos ?></div>
        <div class="texto">Medicos</div>
    </div>
    <div class="tarjeta">
        <div class="numero"><?= $pendientes ?></div>
        <div class="texto">Citas pendientes</div>
    </div>
</div>

</div>
<div class="pie">SIS 256 - Tecnologia y Desarrollo Web - Ing. Carlos David Montellano Barriga</div>
</body>
</html>