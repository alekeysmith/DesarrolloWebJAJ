<?php
// Integrantes: Luis Hernan Huallpa Franses, Joan Alexander Julian
// Clase Carrito - guarda los productos que el cliente va agregando

class Carrito {
    private $items = [];

    public function agregar($codigo, $cantidad = 1) {
        $cant = (int)$cantidad;
        if ($cant < 1) {
            $cant = 1;
        }

        if (isset($this->items[$codigo])) {
            $this->items[$codigo] = $this->items[$codigo] + $cant;
        } else {
            $this->items[$codigo] = $cant;
        }
    }

    public function quitar($codigo) {
        unset($this->items[$codigo]);
    }

    public function vaciar() {
        $this->items = [];
    }

    public function getItems() {
        return $this->items;
    }

    public function estaVacio() {
        return count($this->items) === 0;
    }

    public function cantidadTotal() {
        return array_sum($this->items);
    }

    // recorre el catalogo para sacar el precio de cada item y sumar el total
    public function total(array $catalogo) {
        $total = 0;
        foreach ($this->items as $cod => $cant) {
            foreach ($catalogo as $p) {
                if ($p->getCodigo() === $cod) {
                    $total = $total + ($p->getPrecio() * $cant);
                }
            }
        }
        return round($total, 2);
    }
}
