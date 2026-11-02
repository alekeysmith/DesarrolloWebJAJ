<?php
// datos-receta.php?id=X - devuelve el detalle de UNA receta (fragmento HTML para el modal)
require_once "conexion.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id) {
    http_response_code(400);
    echo "<p>Id de receta no válido.</p>";
    exit;
}

$sql = "SELECT r.id, r.fotografia, r.titulo, t.tiporeceta, r.preparacion
        FROM recetas r
        JOIN tiporeceta t ON r.idtiporeceta = t.id
        WHERE r.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$receta = $stmt->get_result()->fetch_assoc();

if (!$receta) {
    http_response_code(404);
    echo "<p>La receta no existe (quizá ya fue eliminada).</p>";
    exit;
}
?>
<div class="detalle">
    <img width="300" height="300" class="imagen-modal"
         src="images/<?php echo htmlspecialchars($receta['fotografia']); ?>"
         alt="<?php echo htmlspecialchars($receta['titulo']); ?>" id="imagen-modal">
    <div class="detalle-titulo" id="titulo-modal"><?php echo htmlspecialchars($receta['titulo']); ?></div>
    <div class="detalle-tipo" id="tipo-modal">Tipo: <?php echo htmlspecialchars($receta['tiporeceta']); ?></div>
    <div class="detalle-prep" id="receta-modal"><?php echo htmlspecialchars($receta['preparacion']); ?></div>
</div>
