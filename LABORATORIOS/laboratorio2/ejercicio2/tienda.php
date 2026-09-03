<?php
// Integrantes: Luis Hernan Huallpa Franses, Joan Alexander Julian
session_start();
require_once "inc/Producto.php";
require_once "inc/Carrito.php";
require_once "inc/catalogo.php";

// registro del nombre del cliente en una cookie
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nombre"])) {
    setcookie("cliente", $_POST["nombre"], time() + (7 * 24 * 3600), "/");
    header("Location: tienda.php");
    exit();
}

// si todavia no puso su nombre, mostramos el formulario de entrada
if (!isset($_COOKIE["cliente"])) {
?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>TecnoStore USFX - Tienda</title>
        <link rel="stylesheet" href="../estilos.css">
    </head>
    <body class="claro">
        <div class="header"><h2>TecnoStore USFX - Tienda</h2></div>
        <div class="tarjeta" style="max-width: 600px; margin: 40px auto; text-align: left;">
            <h2>Identificacion del cliente</h2>
            <p>Escriba su nombre. Se guardara en una cookie durante 7 dias.</p>
            <form method="post">
                <input type="text" name="nombre" required style="padding: 8px;">
                <button type="submit" class="btn">Ingresar a la tienda</button>
            </form>
        </div>
    </body>
    </html>
<?php
    exit();
}

// contador de visitas usando cookie + sesion para no sumar 2 veces en la misma sesion
if (!isset($_SESSION["visita_registrada"])) {
    $visitas = isset($_COOKIE["visitas"]) ? $_COOKIE["visitas"] + 1 : 1;
    setcookie("visitas", $visitas, time() + (365 * 24 * 3600), "/");
    $_SESSION["visita_registrada"] = true;
    $_COOKIE["visitas"] = $visitas;
}

if (isset($_GET["tema"])) {
    setcookie("tema", $_GET["tema"], time() + (30 * 24 * 3600), "/");
    header("Location: tienda.php");
    exit();
}

if (isset($_POST["agregar"])) {
    $carrito = isset($_SESSION["carrito"]) ? unserialize($_SESSION["carrito"]) : new Carrito();
    $carrito->agregar($_POST["agregar"], $_POST["cantidad"]);
    $_SESSION["carrito"] = serialize($carrito);
    header("Location: tienda.php");
    exit();
}

$carrito = isset($_SESSION["carrito"]) ? unserialize($_SESSION["carrito"]) : new Carrito();
$tema = isset($_COOKIE["tema"]) ? $_COOKIE["tema"] : "claro";
$catalogo = obtenerCatalogo();
?>
<!DOCTYPE html>
<html lang="es" class="<?= htmlspecialchars($tema) ?>">
<head>
    <meta charset="UTF-8">
    <title>TecnoStore USFX - Tienda</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body class="<?= htmlspecialchars($tema) ?>">
    <div class="header">
        <h2>TecnoStore USFX - Tienda</h2>
        <div>
            <a href="carrito.php" class="btn">Carrito (<?= $carrito->cantidadTotal() ?>)</a>
            <a href="tienda.php?tema=<?= $tema === 'claro' ? 'oscuro' : 'claro' ?>" class="btn">Tema <?= $tema === 'claro' ? 'oscuro' : 'claro' ?></a>
            <a href="salir.php" class="btn btn-peligro">Salir</a>
        </div>
    </div>

    <div style="background: rgba(0,0,0,0.05); padding: 20px; border-radius: 8px; margin-bottom: 20px;">
        <h2>Hola <?= htmlspecialchars($_COOKIE["cliente"]) ?></h2>
        <p>Esta es su <strong>visita numero <?= htmlspecialchars($_COOKIE["visitas"]) ?></strong>.</p>
        <p>Su carrito vive en la sesion <code><?= session_id() ?></code>.</p>
    </div>

    <h3>Productos disponibles</h3>
    <div class="galeria">
        <?php foreach ($catalogo as $p) { ?>
            <div class="tarjeta">
                <div style="background:#003366; color:white; padding:10px;">
                    <h3 style="margin: 0;"><?= $p->getCodigo() ?></h3>
                </div>
                <p style="background:#ffc107; color:#000; display:inline-block; padding:3px; font-weight:bold;"><?= strtoupper($p->getCategoria()) ?></p>
                <p><strong><?= $p->getNombre() ?></strong></p>
                <p><strong>Bs <?= number_format($p->getPrecio(), 2) ?></strong></p>

                <?php if ($p->hayStock()) { ?>
                <form method="post">
                    <input type="hidden" name="agregar" value="<?= $p->getCodigo() ?>">
                    <input type="number" name="cantidad" value="1" min="1" max="<?= $p->getStock() ?>" style="width: 50px;">
                    <button type="submit" class="btn">Agregar</button>
                </form>
                <?php } else { ?>
                <p style="color:#dc3545; font-weight:bold;">AGOTADO</p>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</body>
</html>
