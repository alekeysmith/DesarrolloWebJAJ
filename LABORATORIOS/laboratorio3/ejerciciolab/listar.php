<?php
// Integrantes: Julian Joan Alexander
//              Jimenez Amachuy Franco Milton
require_once "proteger.php";
require_once "conexion.php";

$buscar = "";
if (isset($_GET["buscar"])) {
    $buscar = trim($_GET["buscar"]);
}

// lista blanca para el ORDER BY
$validas = ["nombres", "apellidos", "ci", "fecha_nacimiento"];
$orden = "id";
if (isset($_GET["orden"]) && in_array($_GET["orden"], $validas)) {
    $orden = $_GET["orden"];
}

$sql = "SELECT * FROM pacientes
        WHERE nombres LIKE ? OR apellidos LIKE ? OR ci LIKE ?
        ORDER BY $orden";
$stmt = $conn->prepare($sql);
$patron = "%" . $buscar . "%";
$stmt->bind_param("sss", $patron, $patron, $patron);
$stmt->execute();
$res = $stmt->get_result();

$es_admin = ($_SESSION["rol"] == "admin");
include "menu.php";
?>
<div class="contenedor">

<?php if (isset($_SESSION["mensaje"])): ?>
    <div class="aviso <?= isset($_SESSION["tipo"]) ? "aviso-error" : "" ?>">
        <?= htmlspecialchars($_SESSION["mensaje"]) ?>
    </div>
    <?php unset($_SESSION["mensaje"]); unset($_SESSION["tipo"]); ?>
<?php endif; ?>

<h2>Pacientes (<?= $res->num_rows ?> encontrados)</h2>

<form method="GET" action="listar.php" class="panel">
    <label>Buscar por nombre, apellido o CI</label>
    <div class="barra">
        <input type="text" name="buscar" value="<?= htmlspecialchars($buscar) ?>" style="flex:1">
        <input type="submit" value="Buscar" class="boton">
        <a href="listar.php" class="boton boton-sec">Limpiar</a>
        <?php if ($es_admin): ?>
            <a href="form_insertar.php" class="boton boton-ok">Nuevo paciente</a>
        <?php endif; ?>
    </div>
</form>

<?php if ($res->num_rows > 0): ?>
<h3>Haga clic en el titulo de una columna para ordenar</h3>
<table>
    <thead>
    <tr>
        <th>Foto</th>
        <th><a href="listar.php?orden=nombres&buscar=<?= urlencode($buscar) ?>">Nombres</a></th>
        <th><a href="listar.php?orden=apellidos&buscar=<?= urlencode($buscar) ?>">Apellidos</a></th>
        <th><a href="listar.php?orden=ci&buscar=<?= urlencode($buscar) ?>">CI</a></th>
        <th>Telefono</th>
        <th><a href="listar.php?orden=fecha_nacimiento&buscar=<?= urlencode($buscar) ?>">Nacimiento</a></th>
        <?php if ($es_admin): ?><th>Operaciones</th><?php endif; ?>
    </tr>
    </thead>
    <tbody>
    <?php while ($f = $res->fetch_assoc()): ?>
    <tr>
        <td>
            <?php if ($f["fotografia"] != ""): ?>
                <img class="foto" src="images/<?= htmlspecialchars($f["fotografia"]) ?>">
            <?php else: ?>
                <div class="sinfoto">S/F</div>
            <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($f["nombres"]) ?></td>
        <td><?= htmlspecialchars($f["apellidos"]) ?></td>
        <td><?= htmlspecialchars($f["ci"]) ?></td>
        <td><?= htmlspecialchars($f["telefono"]) ?></td>
        <td><?= date("d/m/Y", strtotime($f["fecha_nacimiento"])) ?></td>
        <?php if ($es_admin): ?>
        <td>
            <a class="boton mini" href="form_editar.php?id=<?= $f["id"] ?>">Editar</a>
            <a class="boton boton-no mini" href="delete.php?id=<?= $f["id"] ?>"
               onclick="return confirm('Eliminar?')">Eliminar</a>
        </td>
        <?php endif; ?>
    </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
    <div class="aviso aviso-error">No se encontraron pacientes.</div>
<?php endif; ?>

</div>
<div class="pie">SIS 256 - Tecnologia y Desarrollo Web - Ing. Carlos David Montellano Barriga</div>
</body>
</html>