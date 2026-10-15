<?php
// Integrantes: Julian Joan Alexander
//              Jimenez Amachuy Franco Milton
$pag = basename($_SERVER["PHP_SELF"]);
$en_pacientes = in_array($pag, ["listar.php", "form_insertar.php", "form_editar.php"]);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultorio USFX</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="cabecera">
    <div>
        <h1>Consultorio USFX</h1>
        <p>Sistema de pacientes y citas</p>
    </div>
    <nav>
        <a href="panel.php" class="<?= ($pag == "panel.php") ? "activo" : "" ?>">Panel</a>
        <a href="listar.php" class="<?= $en_pacientes ? "activo" : "" ?>">Pacientes</a>
        <a href="agenda.php" class="<?= ($pag == "agenda.php") ? "activo" : "" ?>">Agenda</a>
        <a href="cerrar_sesion.php">Salir (<?= htmlspecialchars($_SESSION["nombre"]) ?>)</a>
    </nav>
</div>