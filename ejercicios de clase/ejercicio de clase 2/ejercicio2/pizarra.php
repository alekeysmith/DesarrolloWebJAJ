<?php
class Pizarra {
    private $palabra;
    private $color;
    private $color_fondo;

    public function __construct($palabra, $color, $color_fondo) {
        $this->palabra = $palabra;
        $this->color = $color;
        $this->color_fondo = $color_fondo;
    }

    public function triangulo() {
        $longitud =mb_strlen($this->palabra);

        echo "<style>
            .tabla-pizarra {
                border-collapse: collapse;
                margin-top: 20px;
                font-family: Arial, sans-serif;
            }
            .tabla-pizarra td {
                border: 1px solid #000;
                width: 40px;
                height: 40px;
                text-align: center;
                vertical-align: middle;
                font-weight: bold;
            }
            .celda-activa {
                color: {$this->color};
                background-color: {$this->color_fondo};
            }
        </style>";

        echo "<table class='tabla-pizarra'>";

        for ($i =1; $i <= $longitud; $i++) {
            echo "<tr>";
            for ($j = 1; $j <= $longitud; $j++) {
                if ($j <= $i) {
                    $letra = mb_substr($this->palabra, $j - 1, 1);
                    echo "<td class='celda-activa'>{$letra}</td>";
                } else {
                    echo "<td></td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";
    }

}
?>