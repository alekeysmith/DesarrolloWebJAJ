<?php
// Integrantes: Luis Hernan Huallpa Franses, Joan Alexander Julian
session_start();
require_once "inc/Producto.php";
require_once "inc/Carrito.php";
require_once "inc/catalogo.php";

// si no hay cookie de cliente, no deberia estar aca
if (!isset($_COOKIE["cliente"])) {
    header("Location: tienda.php");
    exit();
}

$carrito = isset($_SESSION["carrito"]) ? unserialize($_SESSION["carrito"]) : new Carrito();

if (isset($_GET["quitar"])) {
    $carrito->quitar($_GET["quitar"]);
    $_SESSION["carrito"] = serialize($carrito);
    header("Location: carrito.php");
    exit();
}

if (isset($_GET["vaciar"])) {
    $carrito->vaciar();
    $_SESSION["carrito"] = serialize($carrito);
    header("Location: carrito.php");
    exit();
}

$tema = isset($_COOKIE["tema"]) ? $_COOKIE["tema"] : "claro";
$catalogo = obtenerCatalogo();
?>
<!DOCTYPE html>
<html lang="es" class="<?= htmlspecialchars($tema) ?>">
<head>
    <meta charset="UTF-8">
    <title>TecnoStore USFX - Carrito</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body class="<?= htmlspecialchars($tema) ?>">
    <div class="header">
        <h2>TecnoStore USFX - Carrito</h2>
        <div>
            <a href="tienda.php" class="btn">Seguir comprando</a>
            <a href="salir.php" class="btn btn-peligro">Salir</a>
        </div>
    </div>

    <h3>Compra de <?= htmlspecialchars($_COOKIE["cliente"]) ?></h3>
    <table>
        <tr style="background: #003366; color: white;">
            <th>CÓDIGO</th>
            <th>PRODUCTO</th>
            <th>PRECIO</th>
            <th>CANTIDAD</th>
            <th>SUBTOTAL</th>
            <th>ACCIÓN</th>
        </tr>
        <?php foreach ($carrito->getItems() as $cod => $cant) {
            $prod = buscarProducto($cod, $catalogo);
        ?>
        <tr>
            <td><?= $prod->getCodigo() ?></td>
            <td><?= $prod->getNombre() ?></td>
            <td>Bs <?= number_format($prod->getPrecio(), 2) ?></td>
            <td><?= $cant ?></td>
            <td>Bs <?= number_format($prod->getPrecio() * $cant, 2) ?></td>
            <td><a href="carrito.php?quitar=<?= $cod ?>" class="btn btn-peligro">Quitar</a></td>
        </tr>
        <?php } ?>
        <tr style="background: #003366; color: white;">
            <td colspan="4" style="text-align: right;"><strong>TOTAL (<?= $carrito->cantidadTotal() ?> articulos)</strong></td>
            <td colspan="2"><strong>Bs <?= number_format($carrito->total($catalogo), 2) ?></strong></td>
        </tr>
    </table>

    <div style="margin-top: 15px;">
        <a href="carrito.php?vaciar=1" class="btn btn-peligro">Vaciar carrito</a>
    </div>

    <br><br>
    <h3>Comprobacion de sesiones y cookies</h3>
    <h4>Identificador de la sesion</h4>
    <div class="debug"><?= session_id() ?></div>

    <h4>Contenido de $_SESSION</h4>
    <div class="debug"><pre><?= htmlspecialchars(print_r($_SESSION, true)) ?></pre></div>

    <h4>Contenido de $_COOKIE</h4>
    <div class="debug"><pre><?= htmlspecialchars(print_r($_COOKIE, true)) ?></pre></div>
</body>
</html>
