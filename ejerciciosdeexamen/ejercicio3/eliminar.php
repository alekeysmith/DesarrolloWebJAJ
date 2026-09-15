<?php
require_once "conexion.php";

if (isset($_GET["id"])) {
    $id = (int)$_GET["id"];

    // Prepared Statement para eliminación segura
    $sql = "DELETE FROM libros WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        // Redirige al listado actualizado tras eliminar
        header("Location: listar.php");
        exit();
    } else {
        echo "Error al eliminar: " . $stmt->error;
    }
} else {
    header("Location: listar.php");
    exit();
}
?>