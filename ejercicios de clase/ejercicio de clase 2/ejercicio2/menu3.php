<?php
session_start();
require_once 'pizarra.php';
//Si viene del formulario ,creamos el objeto y lo guardamos en sesion

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['palabra'])) {
    $palabra = $_POST['palabra'];
    $color = $_POST['color'];
    $color_fondo = $_POST['color_fondo'];

    $pizarra = new Pizarra($palabra, $color, $color_fondo);
    $_SESSION['pizarra'] = serialize($pizarra);
    
} 
//verificaion si el objeto existe en sesion
if (!isset($_SESSION['pizarra'])) {
    header("Location: formulario3.html");
    exit;
}
$pizarra = unserialize($_SESSION['pizarra']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú Pizarra</title>
</head>
<body>
    <h2>Menú de Opciones</h2>
    <ul>
        <li><a href="menu3.php?accion=triangulo">Mostrar Triángulo</a></li>
    </ul>
    <br>
    <a href="formulario3.html">Configurar nueva pizarra</a>
    <hr>

    <?php
    // Ejecutar el método según la opción seleccionada en el menú
    if (isset($_GET['accion']) && $_GET['accion'] == 'triangulo') {
        echo "<h3>Figura: Triángulo</h3>";
        $pizarra->triangulo();
    }
    ?>
</body>
</html>