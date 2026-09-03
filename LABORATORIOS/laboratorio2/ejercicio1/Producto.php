<?php
// Integrantes: Luis Hernan Huallpa Franses, Joan Alexander Julian
// Clase Producto - Laboratorio 2, ejercicio 1

class Producto {
    private $codigo;
    private $nombre;
    private $categoria;
    private $precio;
    private $stock;

    public function __construct($codigo, $nombre, $categoria, $precio, $stock) {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->categoria = $categoria;
        $this->precio = $precio;
        $this->stock = $stock;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getStock() {
        return $this->stock;
    }

    // calcula el precio con un descuento, por defecto 10%
    public function getPrecioConDescuento($porcentaje = 10) {
        $descuento = $this->precio * ($porcentaje / 100);
        return round($this->precio - $descuento, 2);
    }

    public function hayStock() {
        if ($this->stock > 0) {
            return true;
        }
        return false;
    }

    // arma el html de la tarjeta del producto para mostrarlo en el catalogo
    public function mostrarTarjeta() {
        if ($this->hayStock()) {
            $stockHtml = "Stock disponible: " . $this->stock . " unidades";
        } else {
            $stockHtml = "<span style='color:red'>Agotado</span>";
        }

        $html = "<div class='tarjeta'>";
        $html .= "<div style='background:#003366;color:white;padding:10px;'>" . $this->codigo . "</div>";
        $html .= "<p style='background:#ffc107;color:black;display:inline-block;padding:3px;'>" . $this->categoria . "</p>";
        $html .= "<p><strong>" . $this->nombre . "</strong></p>";
        $html .= "<p>Bs " . $this->precio . "</p>";
        $html .= "<p><small>Con 10% de descuento: Bs " . $this->getPrecioConDescuento() . "</small></p>";
        $html .= "<p>" . $stockHtml . "</p>";
        $html .= "</div>";

        return $html;
    }
}
