<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado Procesar</title>
    <link rel="stylesheet" href="procesar.css?v=1">
</head>
<body>

<?php
$texto = $_GET["cadena"] ?? '';
$n = (int)($_GET["n"] ?? 0);
$longitud = strlen($texto);

// a) Mostrar la cadena original y la cadena separada por n guiones
echo "<p><strong>Cadena original:</strong> " . $texto . "</p>";
echo "<p><strong>Cadena separada:</strong> ";

for ($i = 0; $i < $longitud; $i++) {
    echo $texto[$i];
    if ($i < $longitud - 1) {
        for ($j = 0; $j < $n; $j++) {
            echo "-";
        }
    }
}
echo "</p><br>";
?>

<!-- b) Tabla horizontal con clases CSS intercaladas -->
<table>
    <tr>
        <?php
        for ($i = 0; $i < $longitud; $i++) {
            $residuo = $i % 3;
            switch ($residuo) {
                case 0:
                    $estilo = "rojo";
                    break;
                case 1:
                    $estilo = "amarillo";
                    break;
                case 2:
                    $estilo = "verde";
                    break;
            }
            echo "<td class='$estilo'>" . $texto[$i] . "</td>";
        }
        ?>
    </tr>
</table>

<br>

<?php
// c) Mostrar la cadena invertida
echo "<p><strong>Cadena invertida:</strong> " . strrev($texto) . "</p>";
?>

</body>
</html>