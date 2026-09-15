<?php
class Estante {
    private $nivel1 = [];
    private $nivel2 = [];
    private $nivel3 = [];
    private $capacidad;

    public function __construct($capacidad) {
        $this->capacidad = (int)$capacidad;
    }

    public function insertar($nivel, $elemento) {
        $nivel = (int)$nivel;
        if ($nivel == 1) {
            if (count($this->nivel1) < $this->capacidad) {
                $this->nivel1[] = $elemento;
            } else {
                echo "<p style='color:red;'>Nivel 1 lleno</p>";
            }
        } elseif ($nivel == 2) {
            if (count($this->nivel2) < $this->capacidad) {
                $this->nivel2[] = $elemento;
            } else {
                echo "<p style='color:red;'>Nivel 2 lleno</p>";
            }
        } elseif ($nivel == 3) {
            if (count($this->nivel3) < $this->capacidad) {
                $this->nivel3[] = $elemento;
            } else {
                echo "<p style='color:red;'>Nivel 3 lleno</p>";
            }
        }
    }

    public function quitar($nivel) {
        $nivel = (int)$nivel;
        if ($nivel == 1) {
            if (!empty($this->nivel1)) {
                array_pop($this->nivel1);
            } else {
                echo "<p style='color:red;'>El Nivel 1 está vacío</p>";
            }
        } elseif ($nivel == 2) {
            if (!empty($this->nivel2)) {
                array_pop($this->nivel2);
            } else {
                echo "<p style='color:red;'>El Nivel 2 está vacío</p>";
            }
        } elseif ($nivel == 3) {
            if (!empty($this->nivel3)) {
                array_pop($this->nivel3);
            } else {
                echo "<p style='color:red;'>El Nivel 3 está vacío</p>";
            }
        }
    }

    public function mostrarEstante() {
        echo "<style>
            .tabla-estante { border-collapse: collapse; margin-top: 10px; }
            .tabla-estante td { border: 1px solid black; width: 80px; height: 35px; text-align: center; }
            .col-nivel { background-color: #d3d3d3; font-weight: bold; width: 90px !important; }
            .bg-nivel3 { background-color: #8da4c4; }
            .bg-nivel2 { background-color: #ffcc00; }
            .bg-nivel1 { background-color: #00b050; color: white; }
        </style>";

        echo "<table class='tabla-estante'>";
        
        // Imprimir Nivel 3
        echo "<tr><td class='col-nivel'>Nivel 3</td>";
        for ($i = 0; $i < $this->capacidad; $i++) {
            $val = $this->nivel3[$i] ?? '';
            $class = ($val !== '') ? 'bg-nivel3' : '';
            echo "<td class='$class'>" . htmlspecialchars($val) . "</td>";
        }
        echo "</tr>";

        // Imprimir Nivel 2
        echo "<tr><td class='col-nivel'>Nivel 2</td>";
        for ($i = 0; $i < $this->capacidad; $i++) {
            $val = $this->nivel2[$i] ?? '';
            $class = ($val !== '') ? 'bg-nivel2' : '';
            echo "<td class='$class'>" . htmlspecialchars($val) . "</td>";
        }
        echo "</tr>";

        // Imprimir Nivel 1
        echo "<tr><td class='col-nivel'>Nivel 1</td>";
        for ($i = 0; $i < $this->capacidad; $i++) {
            $val = $this->nivel1[$i] ?? '';
            $class = ($val !== '') ? 'bg-nivel1' : '';
            echo "<td class='$class'>" . htmlspecialchars($val) . "</td>";
        }
        echo "</tr>";

        echo "</table>";
    }
}
?>