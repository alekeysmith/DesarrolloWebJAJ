<?php
// eliminar.php?id=X - elimina una receta. Se invoca con fetch(..., { method: "DELETE" })
// Responde siempre JSON y usa códigos HTTP correctos (400, 404, 405, 200).
header("Content-Type: application/json; charset=UTF-8");
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
    http_response_code(405);
    echo json_encode(["exito" => false, "mensaje" => "Método no permitido, use DELETE"]);
    exit;
}

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id) {
    http_response_code(400);
    echo json_encode(["exito" => false, "mensaje" => "Id de receta no válido"]);
    exit;
}

$stmt = $conn->prepare("DELETE FROM recetas WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

if ($stmt->affected_rows === 0) {
    http_response_code(404);
    echo json_encode(["exito" => false, "mensaje" => "La receta no existe"]);
    exit;
}

echo json_encode(["exito" => true, "id" => $id]);
