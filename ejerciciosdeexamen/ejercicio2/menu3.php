<?php
session_start();
require_once "estante.php";

$op = $_GET["op"] ?? "";

// Recuperar estante de la sesión si existe
$estante = isset($_SESSION["estante"]) ? unserialize($_SESSION["estante"]) : null;

// Procesamiento de formularios
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accion = $_POST["accion"] ?? "";

    if ($accion == "crear") {
        $cap = $_POST["capacidad"];
        $estante = new Estante($cap);
        $_SESSION["estante"] = serialize($estante);
        header("Location: menu3.php?op=mostrar");
        exit();
    } elseif ($accion == "insertar" && $estante) {
        $nivel = $_POST["nivel"];
        $elem = $_POST["elemento"];
        $estante->insertar($nivel, $elem);
        $_SESSION["estante"] = serialize($estante);
    } elseif ($accion == "quitar" && $estante) {
        $nivel = $_POST["nivel"];
        $estante->quitar($nivel);
        $_SESSION["estante"] = serialize($estante);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú Estante</title>
</head>
<body>
    <h2>Menú Estante</h2>
    <ul>
        <li><a href="menu3.php?op=crear">Crear Estante</a></li>
        <li><a href="menu3.php?op=insertar">Insertar</a></li>
        <li><a href="menu3.php?op=quitar">Quitar</a></li>
        <li><a href="menu3.php?op=mostrar">Mostrar Estante</a></li>
    </ul>

    <hr>

    <?php if ($op == "crear"): ?>
        <h3>Crear Estante</h3>
        <form method="POST">
            <input type="hidden" name="accion" value="crear">
            Capacidad máxima por nivel: <input type="number" name="capacidad" required min="1">
            <input type="submit" value="Crear">
        </form>

    <?php elseif ($op == "insertar"): ?>
        <?php if ($estante): ?>
            <h3>Insertar Elemento</h3>
            <form method="POST">
                <input type="hidden" name="accion" value="insertar">
                Nivel:
                <select name="nivel">
                    <option value="1">Nivel 1</option>
                    <option value="2">Nivel 2</option>
                    <option value="3">Nivel 3</option>
                </select><br><br>
                Nombre del elemento: <input type="text" name="elemento" required><br><br>
                <input type="submit" value="Insertar">
            </form>
        <?php else: ?>
            <p style="color:red;">Primero debe crear el estante.</p>
        <?php endif; ?>

    <?php elseif ($op == "quitar"): ?>
        <?php if ($estante): ?>
            <h3>Quitar Elemento</h3>
            <form method="POST">
                <input type="hidden" name="accion" value="quitar">
                Nivel del cual quitar:
                <select name="nivel">
                    <option value="1">Nivel 1</option>
                    <option value="2">Nivel 2</option>
                    <option value="3">Nivel 3</option>
                </select><br><br>
                <input type="submit" value="Quitar">
            </form>
        <?php else: ?>
            <p style="color:red;">Primero debe crear el estante.</p>
        <?php endif; ?>

    <?php elseif ($op == "mostrar"): ?>
        <h3>Estado Actual del Estante</h3>
        <?php
        if ($estante) {
            $estante->mostrarEstante();
        } else {
            echo "<p style='color:red;'>El estante aún no ha sido creado.</p>";
        }
        ?>
    <?php endif; ?>
</body>
</html>