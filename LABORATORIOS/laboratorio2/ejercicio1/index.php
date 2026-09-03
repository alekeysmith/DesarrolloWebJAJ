<?php
// Integrantes: Luis Hernan Huallpa Franses, Joan Alexander Julian
require_once "catalogo.php";

$catalogo = obtenerCatalogo();
$categorias = obtenerCategorias();
$catSeleccionada = isset($_GET["categoria"]) ? $_GET["categoria"] : "";

// si mandan una categoria que no existe, la ignoramos
if ($catSeleccionada !== "" && !array_key_exists($catSeleccionada, $categorias)) {
    $catSeleccionada = "";
}

$productosMostrados = filtrarPorCategoria($catalogo, $catSeleccionada);
$stats = estadisticas($productosMostrados);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TecnoStore USFX - Catalogo</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
    <div class="header"><h2>TecnoStore USFX - Catalogo</h2></div>

    <h2>1. Filtro de productos</h2>
    <form method="get" style="background:#f8f9fa; padding:20px; border: 1px solid #ccc;">
        <label>Categoria:</label>
        <select name="categoria">
            <option value="">- Todas las categorias -</option>
            <?php foreach ($categorias as $c) { ?>
                <option value="<?= htmlspecialchars($c) ?>" <?php if ($catSeleccionada === $c) echo 'selected'; ?>><?= htmlspecialchars($c) ?></option>
            <?php } ?>
        </select>
        <button type="submit" class="btn">Filtrar</button>
        <p><small>URL generada: <?= htmlspecialchars($_SERVER["REQUEST_URI"]) ?></small></p>
    </form>

    <h2>2. Productos (<?= count($productosMostrados) ?> encontrados)</h2>
    <div class="galeria">
        <?php
        if (count($productosMostrados) > 0) {
            foreach ($productosMostrados as $p) {
                echo $p->mostrarTarjeta();
            }
        } else {
            echo "<p>No hay productos.</p>";
        }
        ?>
    </div>

    <h2>3. Resumen calculado con funciones de arreglo</h2>
    <?php if ($stats) { ?>
    <table>
        <tr style="background:#003366;color:white;"><th>INDICADOR</th><th>VALOR</th></tr>
        <tr><td>Productos listados</td><td><?= $stats['total'] ?></td></tr>
        <tr><td>Unidades en stock</td><td><?= $stats['stock'] ?></td></tr>
        <tr><td>Precio promedio</td><td>Bs <?= number_format($stats['promedio'], 2) ?></td></tr>
        <tr><td>Precio mas alto</td><td>Bs <?= number_format($stats['mayor'], 2) ?></td></tr>
        <tr><td>Precio mas bajo</td><td>Bs <?= number_format($stats['menor'], 2) ?></td></tr>
        <tr style="background:#003366;color:white;"><td>Categorias del catalogo completo</td><td><?= count(contarPorCategoria($catalogo)) ?></td></tr>
    </table>
    <?php } ?>

    <h4>Contenido del arreglo $_GET</h4>
    <div class="debug"><pre><?= htmlspecialchars(print_r($_GET, true)) ?></pre></div>
</body>
</html>
