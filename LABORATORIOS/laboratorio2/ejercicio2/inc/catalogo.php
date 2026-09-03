<?php
// Integrantes: Luis Hernan Huallpa Franses, Joan Alexander Julian
require_once "Producto.php";

function obtenerCatalogo() {
    $lista = [];
    $lista[] = new Producto('P01', 'Teclado mecanico RGB', 'Perifericos', 320.00, 12);
    $lista[] = new Producto('P02', 'Mouse inalambrico', 'Perifericos', 145.50, 6);
    $lista[] = new Producto('P03', 'Monitor 24 pulgadas', 'Pantallas', 1250.00, 5);
    $lista[] = new Producto('P04', 'Monitor curvo 27 pulg.', 'Pantallas', 2100.00, 0);
    $lista[] = new Producto('P05', 'Disco solido 480 GB', 'Almacenamiento', 380.00, 20);
    $lista[] = new Producto('P06', 'Memoria USB 64 GB', 'Almacenamiento', 75.00, 35);
    $lista[] = new Producto('P07', 'Audifonos con microfono', 'Perifericos', 210.00, 0);
    $lista[] = new Producto('P08', 'Disco externo 1 TB', 'Almacenamiento', 640.00, 6);
    return $lista;
}

// busca un producto en el catalogo por su codigo
function buscarProducto($codigo, $catalogo) {
    foreach ($catalogo as $prod) {
        if ($prod->getCodigo() === $codigo) {
            return $prod;
        }
    }
    return null;
}
