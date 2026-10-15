<?php
// Integrantes: Julian Joan Alexander
//               Jimenez Amachuy Franco Milton
require_once "proteger.php";
require_once "permiso.php";
require_once "conexion.php";

$id = (int)$_GET["id"];

$stmt = $conn->prepare("SELECT * FROM pacientes WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$p = $stmt->get_result()->fetch_assoc();

if (!$p) {
    $_SESSION["mensaje"] = "El paciente no existe.";
    $_SESSION["tipo"] = "error";
    header("Location: listar.php");
    exit();
}
include "menu.php";
?>
<div class="contenedor">

<?php if (isset($_SESSION["mensaje"])): ?>
    <div class="aviso aviso-error"><?= htmlspecialchars($_SESSION["mensaje"]) ?></div>
    <?php unset($_SESSION["mensaje"]); unset($_SESSION["tipo"]); ?>
<?php endif; ?>

<h2>Editar paciente</h2>

<form method="POST" action="update.php" enctype="multipart/form-data" class="panel">
    <input type="hidden" name="id" value="<?= $p["id"] ?>">
    <input type="hidden" name="foto_actual" value="<?= htmlspecialchars($p["fotografia"]) ?>">

    <div class="fila">
        <div class="campo">
            <label>Nombres</label>
            <input type="text" name="nombres" value="<?= htmlspecialchars($p["nombres"]) ?>" required>
        </div>
        <div class="campo">
            <label>Apellidos</label>
            <input type="text" name="apellidos" value="<?= htmlspecialchars($p["apellidos"]) ?>" required>
        </div>
    </div>
    <div class="fila">
        <div class="campo">
            <label>Carnet de identidad</label>
            <input type="text" name="ci" value="<?= htmlspecialchars($p["ci"]) ?>" required>
        </div>
        <div class="campo">
            <label>Telefono</label>
            <input type="text" name="telefono" value="<?= htmlspecialchars($p["telefono"]) ?>">
        </div>
        <div class="campo">
            <label>Fecha de nacimiento</label>
            <input type="date" name="fecha_nacimiento" value="<?= $p["fecha_nacimiento"] ?>" required>
        </div>
    </div>

    <div class="campo">
        <label>Fotografia actual</label>
        <?php if ($p["fotografia"] != ""): ?>
            <img class="foto" src="images/<?= htmlspecialchars($p["fotografia"]) ?>">
        <?php else: ?>
            <div class="sinfoto">S/F</div>
        <?php endif; ?>
    </div>
    <div class="campo">
        <label>Cambiar fotografia (opcional)</label>
        <input type="file" name="fotografia">
    </div>

    <input type="submit" value="Guardar cambios" class="boton boton-ok">
    <a href="listar.php" class="boton boton-sec">Cancelar</a>
</form>

</div>
<div class="pie">SIS 256 - Tecnologia y Desarrollo Web - Ing. Carlos David Montellano Barriga</div>
</body>
</html>