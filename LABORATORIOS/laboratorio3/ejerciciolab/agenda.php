<?php
// Integrantes:Julian Joan Alexander  
//             Jimenez Amachuy Franco Milton
require_once "proteger.php";
require_once "conexion.php";

$estados = ["pendiente", "atendida", "cancelada"];
$estado = "";
if (isset($_GET["estado"]) && in_array($_GET["estado"], $estados)) {
    $estado = $_GET["estado"];
}

$sql = "SELECT c.fecha, c.hora, c.motivo, c.estado,
               CONCAT(p.nombres, ' ', p.apellidos) AS paciente,
               CONCAT(m.nombres, ' ', m.apellidos) AS medico,
               e.nombre AS especialidad
        FROM citas c
        INNER JOIN pacientes p ON c.paciente_id = p.id
        INNER JOIN medicos m ON c.medico_id = m.id
        INNER JOIN especialidades e ON m.especialidad_id = e.id";

if ($estado != "") {
    $sql .= " WHERE c.estado = ? ORDER BY c.fecha, c.hora";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $estado);
} else {
    $sql .= " ORDER BY c.fecha, c.hora";
    $stmt = $conn->prepare($sql);
}
$stmt->execute();
$res = $stmt->get_result();

include "menu.php";
?>
<div class="contenedor">

<h2>Agenda de citas (<?= $res->num_rows ?>)</h2>

<form method="GET" action="agenda.php" class="panel">
    <label>Filtrar por estado</label>
    <div class="barra">
        <select name="estado" style="width:200px">
            <option value="">-- Todos --</option>
            <?php foreach ($estados as $e): ?>
                <option value="<?= $e ?>" <?= ($estado == $e) ? "selected" : "" ?>><?= ucfirst($e) ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Filtrar" class="boton">
    </div>
</form>

<h3>Datos tomados de cuatro tablas relacionadas con INNER JOIN</h3>
<table>
    <thead>
    <tr>
        <th>Fecha</th><th>Hora</th><th>Paciente</th><th>Medico</th>
        <th>Especialidad</th><th>Motivo</th><th>Estado</th>
    </tr>
    </thead>
    <tbody>
    <?php while ($f = $res->fetch_assoc()): ?>
    <tr>
        <td><?= date("d/m/Y", strtotime($f["fecha"])) ?></td>
        <td><?= substr($f["hora"], 0, 5) ?></td>
        <td><?= htmlspecialchars($f["paciente"]) ?></td>
        <td><?= htmlspecialchars($f["medico"]) ?></td>
        <td><?= htmlspecialchars($f["especialidad"]) ?></td>
        <td><?= htmlspecialchars($f["motivo"]) ?></td>
        <td><span class="etiqueta et-<?= $f["estado"] ?>"><?= $f["estado"] ?></span></td>
    </tr>
    <?php endwhile; ?>
    </tbody>
</table>

</div>
<div class="pie">SIS 256 - Tecnologia y Desarrollo Web - Ing. Carlos David Montellano Barriga</div>
</body>
</html>