<?php
// catalogo.php - devuelve SOLO un fragmento HTML (sin <html>/<body>),
// porque fetch() lo inserta dentro de #contenido.
require_once "conexion.php";

$sql = "SELECT r.id, r.fotografia, r.titulo, t.tiporeceta
        FROM recetas r
        JOIN tiporeceta t ON r.idtiporeceta = t.id
        ORDER BY r.id";
$resultado = $conn->query($sql);

if ($resultado && $resultado->num_rows > 0) {
?>
<div class="grilla">
<?php while ($fila = $resultado->fetch_assoc()) { ?>
    <div class="tarjeta" onclick="abrirmodal(<?php echo (int)$fila['id']; ?>)">
        <img class="receta"
             src="images/<?php echo htmlspecialchars($fila['fotografia']); ?>"
             alt="<?php echo htmlspecialchars($fila['titulo']); ?>">
        <div class="tarjeta-titulo"><?php echo htmlspecialchars($fila['titulo']); ?></div>
        <div class="tarjeta-tipo"><?php echo htmlspecialchars($fila['tiporeceta']); ?></div>
    </div>
<?php } ?>
</div>
<?php
} else {
    echo "<p>No hay recetas registradas.</p>";
}
$conn->close();
