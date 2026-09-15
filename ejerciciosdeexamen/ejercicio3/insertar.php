<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = trim($_POST["titulo"]);
    $autor = trim($_POST["autor"]);
    $anio = (int)$_POST["anio"];
    $editorial = trim($_POST["editorial"]);

    // Prepared Statement para inserción segura
    $sql = "INSERT INTO libros (titulo, autor, anio, editorial) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssis", $titulo, $autor, $anio, $editorial);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        // Redirige al listado tras insertar
        header("Location: listar.php");
        exit();
    } else {
        echo "Error al registrar el libro: " . $stmt->error;
    }
}
?>