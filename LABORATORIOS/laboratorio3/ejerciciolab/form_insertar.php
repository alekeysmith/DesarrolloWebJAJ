<?php
// Integrantes: Julian Joan Alexander
//              Jimenez Amachuy Franco Milton
require_once "proteger.php";
require_once "permiso.php";
include "menu.php";
?>
<div class="contenedor">

<?php if (isset($_SESSION["mensaje"])): ?>
    <div class="aviso aviso-error"><?= htmlspecialchars($_SESSION["mensaje"]) ?></div>
    <?php unset($_SESSION["mensaje"]); unset($_SESSION["tipo"]); ?>
<?php endif; ?>

<h2>Registrar un paciente</h2>

<form method="POST" action="insert.php" enctype="multipart/form-data" class="panel">
    <div class="fila">
        <div class="campo">
            <label>Nombres</label>
            <input type="text" name="nombres" required>
        </div>
        <div class="campo">
            <label>Apellidos</label>
            <input type="text" name="apellidos" required>
        </div>
    </div>
    <div class="fila">
        <div class="campo">
            <label>Carnet de identidad</label>
            <input type="text" name="ci" required>
        </div>
        <div class="campo">
            <label>Telefono</label>
            <input type="text" name="telefono">
        </div>
        <div class="campo">
            <label>Fecha de nacimiento</label>
            <input type="date" name="fecha_nacimiento" required>
        </div>
    </div>
    <div class="campo">
        <label>Fotografia (jpg, jpeg, png o webp - maximo 2 MB)</label>
        <input type="file" name="fotografia">
    </div>
    <input type="submit" value="Guardar paciente" class="boton boton-ok">
    <a href="listar.php" class="boton boton-sec">Cancelar</a>
</form>

</div>
<div class="pie">SIS 256 - Tecnologia y Desarrollo Web - Ing. Carlos David Montellano Barriga</div>
</body>
</html>