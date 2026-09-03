<?php
// Integrantes: Luis Hernan Huallpa Franses, Joan Alexander Julian
// funciones para manejar el catalogo de productos
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

function obtenerCategorias() {
    return array(
        'Perifericos' => 'Perifericos',
        'Pantallas' => 'Pantallas',
        'Almacenamiento' => 'Almacenamiento'
    );
}

// si no se manda categoria, devuelve todos los productos
function filtrarPorCategoria(array $productos, $categoria) {
    if (empty($categoria)) {
        return $productos;
    }
    $resultado = [];
    foreach ($productos as $p) {
        if ($p->getCategoria() === $categoria) {
            $resultado[] = $p;
        }
    }
    return $resultado;
}

// calcula algunos datos del listado que se esta mostrando
function estadisticas(array $productos) {
    if (count($productos) === 0) {
        return null;
    }

    $precios = [];
    $stocks = [];
    foreach ($productos as $p) {
        $precios[] = $p->getPrecio();
        $stocks[] = $p->getStock();
    }

    return [
        'total' => count($productos),
        'stock' => array_sum($stocks),
        'promedio' => array_sum($precios) / count($productos),
        'mayor' => max($precios),
        'menor' => min($precios)
    ];
}

function contarPorCategoria(array $productos) {
    $conteos = [];
    foreach ($productos as $p) {
        $cat = $p->getCategoria();
        if (!isset($conteos[$cat])) {
            $conteos[$cat] = 0;
        }
        $conteos[$cat] = $conteos[$cat] + 1;
    }
    return $conteos;
}
